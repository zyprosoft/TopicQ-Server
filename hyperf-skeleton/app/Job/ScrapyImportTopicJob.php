<?php


namespace App\Job;
use App\Constants\Constants;
use App\Model\Comment;
use App\Model\ManagerAvatarUser;
use App\Model\Post;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Hyperf\AsyncQueue\Job;
use Hyperf\DbConnection\Db;
use Hyperf\Guzzle\CoroutineHandler;
use Hyperf\Utils\ApplicationContext;
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

    protected int $forumId;

    /**
     * 初始化client的配置
     * @var array
     */
    protected $options = [];

    /**
     * @var Client
     */
    protected $client;

    public function __construct(string $topicId, string $sessionHash, int $forumId)
    {
        $this->topicId = $topicId;
        $this->sessionHash = $sessionHash;
        $this->forumId = $forumId;
        $stack = null;
        if (Coroutine::getCid() > 0) {
            $stack = HandlerStack::create(new CoroutineHandler());
        }
        $config = array_replace(['handler' => $stack], $this->options);
        $this->client = ApplicationContext::getContainer()->make(Client::class, ['config' => $config]);
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
        $url = $this->baseUrl.'&topic_id='.$this->topicId.'&sessionhash='.$this->sessionHash;
        $result = $this->client->get($url);
        Log::info('抓取帖子详情结果:'.$result->getBody());
        $result = json_decode($result->getBody(),true);
        if($result['code'] == 1 && $result['message'] == 'SUCCESS') {
            $replyList = collect($result['data']['replies']);
            $posterFloor = $replyList->first;
            //添加帖子
            $content = $posterFloor['data']['content'];
            $publishContent = [];
            $post = new Post();
            $post->only_self_visible = 1;
            $post->owner_id = $this->getRandomUser()->avatar_user_id;
            $post->title = $result['title'];
            $post->read_count = $result['click_times'];
            $post->forum_id = $this->forumId;
            foreach ($content as $key => $item) {
                if($key == 'text') {
                    $publishContent[] = [
                        'type' => 'text',
                        'type_name' => '文本',
                        'content' => $item,
                        'is_bold' => 0,
                        'font_size' => 14,
                        'display_font_size' => 32,
                        'font_size_name' => 'lg',
                        'text_color' => 'black'
                    ];
                }
                if($key == 'image') {
                    //直接远程转存
                    $accessKey = config('file.storage.qiniu.accessKey');
                    $secretKey = config('file.storage.qiniu.secretKey');
                    $bucket = config('file.storage.qiniu.bucket');
                    $auth = new Auth($accessKey, $secretKey);
                    $bucketManager = new BucketManager($auth);
                    $key = time() . '.png';
                    list($ret, $err) = $bucketManager->fetch($url, $bucket, $key);
                    Log::info("=====> fetch $url to bucket: $bucket  key: $key\n");
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
                            'remote' => $remoteUrl,
                        ];
                    }
                }
                $post->rich_content = json_encode($publishContent);
                $post->audit_status = Constants::STATUS_OK;
                $post->saveOrFail();
            }

            //评论
            Db::transaction(function () use ($replyList,$post){
                $replyList = $replyList->slice(1,$replyList->count()-2);
                $replyList->map(function (array $item) use ($post) {
                    $comment = new Comment();
                    $comment->post_id = $post->post_id;

                });
            });

        }
    }
}