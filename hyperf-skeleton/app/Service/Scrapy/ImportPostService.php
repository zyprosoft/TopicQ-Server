<?php


namespace App\Service\Scrapy;


use App\Constants\Constants;
use App\Model\Comment;
use App\Model\FilterTopic;
use App\Model\ManagerAvatarUser;
use App\Model\Post;
use App\Service\UserService;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Hyperf\DbConnection\Db;
use Hyperf\Guzzle\CoroutineHandler;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Utils\Str;
use Psr\Container\ContainerInterface;
use Qiniu\Auth;
use Qiniu\Storage\BucketManager;
use Swoole\Coroutine;
use ZYProSoft\Log\Log;
use App\Service\BaseService;

class ImportPostService extends BaseService
{
    protected $url = 'https://tieba.baidu.com/mo/q/frs/page/m?kw=%E5%A4%A7%E5%AD%A6&sort_type=1&res_num=20&default_pro=1&obj_source=&open_source=&fr=smallapp&timestamp=1631421694489&tbs=e3bccceeae9614a61631420473&itb_tbs=e3bccceeae9614a61631420473&source_platform=weixin&randomid=ixgpaarnq6c1631420472148&call_from=weixin&sign=4bd3ac3c465cdb6c9e40fb6df87e3918';

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

    protected int $pageIndex = 0;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $stack = null;
        if (Coroutine::getCid() > 0) {
            $stack = HandlerStack::create(new CoroutineHandler());
        }
        $config = array_replace(['handler' => $stack], $this->options);
        $this->client = ApplicationContext::getContainer()->make(Client::class, ['config' => $config]);
    }

    public function isNeedFilter(string $content)
    {
        $search = explode(',',env('REF_FILTER_WORDS'));
        if (Str::contains($content,$search)) {
            return true;
        }
        return false;
    }

    public function getOneTopic(int $pnum=0)
    {
        $url = $this->url.'&pnum='.$pnum;
        $result = $this->client->get($url);
        Log::info('帖子列表:'.$result->getBody());
        $result = json_decode($result->getBody(),true);
        $threadList = $result['data']['frs_data']['thread_list'];

        $findOne = false;

        //第一贴是吧务
        for ($index = 1 ;$index < count($threadList); $index++) {
            $item = $threadList[$index];
            $title = $item['title'];
            if(isset($title)) {
                $isFilter = $this->isNeedFilter($title);
                if($isFilter) {
                    Log::info("标题不符合，需要过滤");
                    continue;
                }
                $summary = $item['abstract'];
                $isFilter = $this->isNeedFilter($summary);
                if($isFilter) {
                    Log::info('概要不符合，需要过滤');
                    continue;
                }
                //是否已经引用过
                $post = Post::query()->where('ref_id',$item['tid'])->first();
                if($post instanceof Post) {
                    Log::info('已经引用过的帖子');
                    continue;
                }
                //是否已经过滤的
                $post = FilterTopic::query()->where('ref_id',$item['tid'])->first();
                if($post instanceof FilterTopic) {
                    Log::info('需要过滤的帖子');
                    continue;
                }
                //符合需求，去获取帖子详情
                $this->getTopicDetail($item['tid']);
                $findOne = true;
                break;
            }
        }
        //没有合适的帖子，进行翻页继续找
        if($findOne == false) {
            $this->pageIndex++;
            $this->getOneTopic($this->pageIndex);
        }
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

    public function getTopicDetail(string $topicId)
    {
        $url = 'https://tieba.baidu.com/mo/q/pb/page/m?rn=20&see_lz=0&source_platform=weixin&r=0&pn=0&obj_source=frs&open_source=&calltype=&fr=smallapp&timestamp=1631422896886&tbs=8f70ba506023acb31631422850&itb_tbs=8f70ba506023acb31631422850&randomid=ko6re0hc53g1631421920389&call_from=weixin&sign=1c2640e32ec7a6ca24e13560fd7f7d3a';
        $url = $url.'&kz='.$topicId;
        $result = $this->client->get($url);
        $result = json_decode($result->getBody(),true);
        if($result['no'] != 0 && !empty($result['error'])) {
            Log::info("获取帖子详情失败!");
            return;
        }
        $postList = $result['data']['post_list'];
        $postFloor = $postList[0];
        $title = $postFloor['title'];
        $content = $postFloor['content'];

        //直接远程转存
        $accessKey = config('file.storage.qiniu.accessKey');
        $secretKey = config('file.storage.qiniu.secretKey');
        $bucket = config('file.storage.qiniu.bucket');
        $auth = new Auth($accessKey, $secretKey);
        $bucketManager = new BucketManager($auth);

        $publishContent = [];
        $post = new Post();
        $post->owner_id = $this->getRandomUser()->avatar_user_id;
        if(isset($title) && !empty($title)) {
            $post->title = $title;
        }else{
            foreach ($content as $item) {
                //文本，过滤
                $textContent = $item['text'];
                $textContent = str_replace('贴吧','翠湖畔',$textContent);
                $textContent = str_replace('吧友','畔友',$textContent);
                $isFilter = $this->isNeedFilter($textContent);
                if($isFilter) {
                    $filterPost = new FilterTopic();
                    $filterPost->ref_id = $topicId;
                    $filterPost->save();
                    //获取下一个
                    $this->getOneTopic();
                    return;
                }
                if(isset($post->summary)) {
                    if(mb_strlen($textContent) < 14) {
                        $post->summary = $textContent;
                    }else{
                        $post->summary = mb_substr($textContent,0,14);
                    }
                }else{
                    $filterPost = new FilterTopic();
                    $filterPost->ref_id = $topicId;
                    $filterPost->save();
                    //获取下一个
                    $this->getOneTopic();
                    return;
                }
            }
        }
        $post->read_count = rand(0,999);
        $post->ref_id = $topicId;
        $post->created_at = $postFloor['time'];
        $post->forum_id = 1;

        //提取全部图片
        $imageList = [];
        $imageIds = [];

        foreach ($content as $item) {
            $type = $item['type'];
            if($type == 0) {
                //文本，过滤
                $textContent = $item['text'];
                $textContent = str_replace('贴吧','翠湖畔',$textContent);
                $textContent = str_replace('吧友','畔友',$textContent);
                $isFilter = $this->isNeedFilter($textContent);
                if($isFilter) {
                    $filterPost = new FilterTopic();
                    $filterPost->ref_id = $topicId;
                    $filterPost->save();
                    //获取下一个
                    $this->getOneTopic();
                    return;
                }
                $textContent = str_replace(['<br>','<br/>'],'\n',$textContent);
                $publishContent[] = [
                    'type' => 'text',
                    'type_name' => '文本',
                    'content' => $textContent,
                    'is_bold' => 0,
                    'font_size' => 14,
                    'display_font_size' => 32,
                    'font_size_name' => 'lg',
                    'text_color' => 'black'
                ];
            }
            if($type == 3) {
                //图片，进行转存
                $imageUrl = $item['src'];
                $key = 't'.time();
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

        $post->image_ids = implode(';',$imageIds);
        $post->rich_content = json_encode($publishContent);
        $post->audit_status = Constants::STATUS_OK;
        $post->saveOrFail();

        //统计个人信息
        $service = ApplicationContext::getContainer()->get(UserService::class);
        $service->queueService->refreshUserCountInfo($post->owner_id);

        Log::info("({$topicId})开始异步转存评论...");

        $this->importComment($topicId,$post,$postFloor);
    }

    public function importComment(string $topicId, Post $post, array $originPost)
    {
        $url = 'https://tieba.baidu.com/mo/q/pb/page/m?rn=20&see_lz=0&source_platform=weixin&r=0&pn=0&fr=smallapp&timestamp=1631420705804&tbs=e3bccceeae9614a61631420473&itb_tbs=e3bccceeae9614a61631420473&randomid=ixgpaarnq6c1631420472148&call_from=weixin&sign=2f2bfaf9675e4aff3bbf40ba015e0d8f';
        $url = $url.'&kz='.$topicId;
        $result = $this->client->get($url);
        $result = json_decode($result->getBody(),true);
        if($result['no'] != 0 && !empty($result['error'])) {
            Log::info("获取评论详情失败!");
            return;
        }
        $commentList = $result['data']['post_list'];
        if(count($commentList) < 2) {
            Log::info("帖子($topicId)没有评论...");
            return;
        }

        //直接远程转存
        $accessKey = config('file.storage.qiniu.accessKey');
        $secretKey = config('file.storage.qiniu.secretKey');
        $bucket = config('file.storage.qiniu.bucket');
        $auth = new Auth($accessKey, $secretKey);
        $bucketManager = new BucketManager($auth);

        Db::transaction(function () use ($topicId,$post,$commentList,$originPost,$bucket,$bucketManager) {
            $index = 0;
            $commentCount = 0;
            foreach ($commentList as $item) {
                Log::info('开始处理评论:'.json_encode($item));
                $comment = new Comment();
                if($originPost['author']['id'] == $item['author']['id']) {
                    $comment->owner_id = $post->owner_id;
                }else{
                    $comment->owner_id = $this->getRandomUser()->avatar_user_id;
                }
                $comment->post_id = $post->post_id;
                $comment->created_at = $item['time'];
                //内容
                $content = $item['content'];
                $textContent = '';
                //提取全部图片
                $imageList = [];
                $imageIds = [];
                foreach ($content as $subItem) {
                    if ($subItem['type'] == 0) {
                        $textContent .= $subItem['text'];
                        $textContent = str_replace('贴吧','翠湖畔',$textContent);
                        $textContent = str_replace('吧友','畔友',$textContent);
                    }
                    if($subItem['type'] == 3) {
                        //图片，进行转存
                        $imageUrl = $subItem['src'];
                        $key = 't'.time();
                        list($ret, $err) = $bucketManager->fetch($imageUrl, $bucket, $key);
                        Log::info("=====> fetch $imageUrl to bucket: $bucket  key: $key\n");
                        if ($err !== null) {
                            Log::info("转存图片失败:".json_encode($err));
                        } else {
                            //转存成功
                            $fileKey = $ret['key'];
                            $remoteUrl = env('QINIU_CDN_DOMAIN').$fileKey;
                            //存储数据
                            $imageList[] = $remoteUrl;
                            $imageIds[] = $key;
                        }
                    }
                }
                $textContent = str_replace(['<br>','<br/>'],'\n',$textContent);
                $comment->content = $textContent;
                $comment->audit_status = Constants::STATUS_OK;
                if (!empty($imageIds) && !empty($imageList)) {
                    $comment->image_ids = implode(';', $imageIds);
                    $comment->image_list = implode(';', $imageList);
                }
                Log::info("将要存储评论:" . json_encode($comment));
                $comment->save();
                $index++;
                $commentCount++;
            }
            $post->comment_count = $commentCount;
            $post->save();
        });
    }
}