<?php


namespace App\Job;
use App\Constants\Constants;
use App\Model\Comment;
use App\Model\ManagerAvatarUser;
use App\Model\Post;
use App\Service\UserService;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Hyperf\AsyncQueue\Job;
use Hyperf\DbConnection\Db;
use Hyperf\Guzzle\CoroutineHandler;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Utils\Str;
use Qiniu\Auth;
use Swoole\Coroutine;
use ZYProSoft\Constants\ErrorCode;
use ZYProSoft\Exception\HyperfCommonException;
use ZYProSoft\Log\Log;
use Qiniu\Storage\BucketManager;

class ScrapyImportTopicJob extends Job
{
    protected string $baseUrl = 'https://weixin.libaclub.com/weChatService/interface.php?act=get_reply_info&page=1';

    protected string $topicId;

    protected string $sessionHash;

    protected $forumId;

    protected $circleId;

    /**
     * 初始化client的配置
     * @var array
     */
    protected $options = [
        'headers'=>[
            'Referer' => 'https://servicewechat.com/wx82e832ab625f9e82/47/page-frame.html',
            'User-Agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 11_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E217 MicroMessenger/6.8.0(0x16080000) NetType/WIFI Language/en Branch/Br_trunk MiniProgramEnv/Mac'
        ]
    ];

    /**
     * @var Client
     */
    protected $client;

    public function __construct(string $topicId, string $sessionHash, int $forumId = null, int $circleId = null)
    {
        $this->topicId = $topicId;
        $this->sessionHash = $sessionHash;
        $this->forumId = $forumId;
        $this->circleId = $circleId;
    }

    protected function getRandomUser()
    {
        //获取随机用户
        $max = ManagerAvatarUser::count()-1;
        $random = rand(0,$max);
        return ManagerAvatarUser::query()->offset($random)
            ->limit(1)
            ->firstOrFail();
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        $stack = null;
        if (Coroutine::getCid() > 0) {
            $stack = HandlerStack::create(new CoroutineHandler());
        }
        $config = array_replace(['handler' => $stack], $this->options);
        $this->client = ApplicationContext::getContainer()->make(Client::class, ['config' => $config]);
        $url = $this->baseUrl.'&topic_id='.$this->topicId.'&sessionhash='.$this->sessionHash;
        $result = $this->client->get($url);
        Log::info('抓取帖子详情结果:'.$result->getBody());
        $result = json_decode($result->getBody(),true);
        if($result['code'] == 1 && $result['message'] == 'SUCCESS') {
            $replyList = collect($result['data']['replies']);
            Log::info("replyList:".json_encode($replyList));
            $posterFloor = $replyList->first();
            Log::info("获取帖子信息:".json_encode($posterFloor));
            //添加帖子
            $content = $posterFloor['data']['content'];
            $publishContent = [];
            $post = new Post();
//            $post->only_self_visible = 1;
            $post->owner_id = $this->getRandomUser()->avatar_user_id;
            $post->title = $result['data']['title'];
            $post->read_count = rand(0,999);
            if(isset($this->forumId)) {
                $post->forum_id = $this->forumId;
            }

            //直接远程转存
            $accessKey = config('file.storage.qiniu.accessKey');
            $secretKey = config('file.storage.qiniu.secretKey');
            $bucket = config('file.storage.qiniu.bucket');
            $auth = new Auth($accessKey, $secretKey);
            $bucketManager = new BucketManager($auth);

            //提取全部图片
            $imageList = [];
            $imageIds = [];
            if(isset($this->circleId)) {
                $post->circle_id = $this->circleId;
                foreach ($content as $item) {
                    if (isset($item['image'])) {
                        $imageUrl = $item['image'];
                        Log::info("帖子包含图片，开始远端转存!{$this->topicId}");
                        $key = time();
                        list($ret, $err) = $bucketManager->fetch($imageUrl, $bucket, $key);
                        Log::info("=====> fetch $imageUrl to bucket: $bucket  key: $key\n");
                        if ($err !== null) {
                            Log::info("转存图片失败:".json_encode($err));
                        } else {
                            //转存成功
                            $fileKey = $ret['key'];
                            $remoteUrl = env('QINIU_CDN_DOMAIN').$fileKey;
                            $imageList[] = $remoteUrl;
                            $imageIds[] = $key;
                        }
                    }
                }
            }

            foreach ($content as $item) {
                if(isset($item['text'])) {
                    $publishContent[] = [
                        'type' => 'text',
                        'type_name' => '文本',
                        'content' => $item['text'],
                        'is_bold' => 0,
                        'font_size' => 14,
                        'display_font_size' => 32,
                        'font_size_name' => 'lg',
                        'text_color' => 'black'
                    ];
                    if (mb_strlen($item['text']) < 40) {
                        $post->summary = $item['text'];
                    } else {
                        $post->summary = mb_substr($item['text'], 0, 40);
                    }
                }
                if(isset($item['image']) && !isset($this->circleId)) {
                    $imageUrl = $item['image'];
                    Log::info('原图片:'.$imageUrl);
                    Log::info("帖子包含图片，开始远端转存!{$this->topicId}");
                    $key = time();
                    list($ret, $err) = $bucketManager->fetch($imageUrl, $bucket, $key);
                    Log::info("=====> fetch $imageUrl to bucket: $bucket  key: $key\n");
                    if ($err !== null) {
                        Log::info("转存图片失败:".json_encode($err));
                    } else {
                        //转存成功
                        $fileKey = $ret['key'];
                        $remoteUrl = env('QINIU_CDN_DOMAIN').$fileKey;
                        //存储数据
                        $publishContent[] = [
                            'type' => 'big_image',
                            'type_name' => '大图',
                            'image' => [
                                'remote' => $remoteUrl
                            ],
                        ];
                        $imageIds[] = $key;
                    }
                }
            }
            if(isset($this->circleId)) {
                //存储数据
                $publishContent[] = [
                    'type' => 'grid_image',
                    'type_name' => '宫格',
                    'url_list' => $imageList,
                ];
            }
            $post->image_ids = implode(';',$imageIds);
            $post->rich_content = json_encode($publishContent);
            $post->audit_status = Constants::STATUS_OK;
            $post->saveOrFail();
            Log::info("完成帖子转存!({$this->topicId}),开始评论转存...");

            $startTime = Carbon::now();

            //统计个人信息
            $service = ApplicationContext::getContainer()->get(UserService::class);
            $service->queueService->refreshUserCountInfo($post->owner_id);

            //评论
            Db::transaction(function () use ($replyList,$post,$bucketManager,$bucket,$startTime){
                $replyList = $replyList->slice(1,$replyList->count()-2);
                $index = 0;
                $commentCount = 0;
                $postTime = null;
                $replyList->map(function (array $item) use (&$postTime,&$commentCount,$post,$bucketManager,$bucket,$startTime,&$index) {
                    if(isset($item['data']['content'])) {
                        $comment = new Comment();
                        $comment->post_id = $post->post_id;
                        $comment->post_owner_id = $post->owner_id;
                        $user = $this->getRandomUser();
                        $comment->owner_id = $user->avatar_user_id;
                        $imageList = [];
                        $imageIds = [];
                        $contentList = $item['data']['content'];
                        foreach ($contentList as $subItem) {
                            if (isset($subItem['text'])) {
                                Log::info("评论内容:" . $subItem['text']);
                                $comment->content = $subItem['text'];
                            }
                            if (isset($subItem['image'])) {
                                $imageUrl = $subItem['image'];
                                Log::info("评论包含图片，开始远端转存!{$this->topicId}");
                                $key = time();
                                list($ret, $err) = $bucketManager->fetch($imageUrl, $bucket, $key);
                                Log::info("=====> fetch $imageUrl to bucket: $bucket  key: $key\n");
                                if ($err !== null) {
                                    Log::info("转存图片失败:" . json_encode($err));
                                } else {
                                    //转存成功
                                    $fileKey = $ret['key'];
                                    $remoteUrl = env('QINIU_CDN_DOMAIN') . $fileKey;
                                    $imageList[] = $remoteUrl;
                                    $imageIds[] = $key;
                                }
                            }
                        }
                        if (!empty($imageIds) && !empty($imageList)) {
                            $comment->image_ids = implode(';', $imageIds);
                            $comment->image_list = implode(';', $imageList);
                        }
                        $rand = rand(0, 10);
                        $subMinute = $index * 2 - $rand;
                        $comment->created_at = $startTime->subRealMinutes($subMinute);
                        $postTime = $comment->created_at;
                        Log::info("将要存储评论:" . json_encode($comment));
                        $comment->save();
                        $index++;
                        $commentCount++;
                    }
                });
                $post->comment_count = $commentCount;
                if(isset($postTime)) {
                    $post->created_at = $postTime;
                }
                $post->save();
            });

        }
    }
}