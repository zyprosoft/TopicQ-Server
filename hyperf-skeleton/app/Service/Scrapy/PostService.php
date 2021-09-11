<?php


namespace App\Service\Scrapy;

use App\Job\ScrapyImportTopicJob;
use App\Model\DelayPostTask;
use App\Model\FilterTopic;
use App\Model\Forum;
use App\Model\Scrapy\Comment;
use App\Model\Scrapy\Post;
use App\Model\Scrapy\Thread;
use App\Service\BaseService;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Hyperf\AsyncQueue\Driver\DriverFactory;
use Hyperf\Database\Model\Builder;
use Hyperf\Guzzle\CoroutineHandler;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Utils\Str;
use Psr\Container\ContainerInterface;
use Swoole\Coroutine;
use ZYProSoft\Log\Log;

class PostService extends BaseService
{
    protected $url = 'https://weixin.libaclub.com/weChatService/interface.php?act=getTopicListDel';

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

    public function getPostList(int $pageIndex,string $sessionHash)
    {
        $url = $this->url.'&page='.$pageIndex.'&sessionhash='.$sessionHash;
        $result = $this->client->get($url);
        $result = json_decode($result->getBody(),true);
        if($result['code'] == 1 && $result['message'] == 'SUCCESS') {
            return ['list'=>$result['data'],'total'=>1000];
        }
        return ['list'=>[],'total'=>0];
    }

    public function getCommentList(int $postId, int $pageIndex, int $pageSize)
    {
        $list = Post::query()->where('thread_id', $postId)
                               ->offset($pageIndex * $pageSize)
                               ->limit($pageSize)
                               ->get();
        $total = Post::query()->where('thread_id', $postId)->count();
        return ['list'=>$list,'total'=>$total];
    }

    public function addDelayPost(string $postId, string $sessionHash, int $forumId = null, int $circleId = null)
    {
        $this->push(new ScrapyImportTopicJob($postId,$sessionHash,$forumId,$circleId));
        return $this->success();
    }

    public function isNeedFilter(string $content)
    {
        $search = explode(',',env('REF_FILTER_WORDS'));
        if (Str::contains($content,$search)) {
            return true;
        }
        return false;
    }

    public function importTopic()
    {
        $sessionHash = env('REF_SESSION_HASH');
        $forumId = Forum::all()->pluck('forum_id')->random();
        $postService = ApplicationContext::getContainer()->get(PostService::class);
        $topicList = $postService->getPostList(0,$sessionHash);
        $list = collect($topicList['list']);
        $postIdList = $list->pluck('topic_id');
        $existPostList = \App\Model\Post::query()->select(['ref_id','title'])->whereIn('ref_id',$postIdList)
            ->get()
            ->keyBy('ref_id');
        for ($index = 0;$index < count($list);$index++) {
            $item = $list[$index];
            $isNeedFilter = $this->isNeedFilter($item['title']);
            if($isNeedFilter) {
                Log::info('敏感标题，不引用:'.$item['title']);
                continue;
            }
            $topicId = $item['topic_id'];
            $filterTopic = FilterTopic::query()->where('ref_id',$topicId)->first();
            if ($filterTopic instanceof FilterTopic) {
                Log::info("需要过滤的敏感帖子:".$topicId);
                continue;
            }
            if (isset($existPostList[$topicId])) {
                Log::info('已经存在此引用'.$topicId);
                continue;
            }
            $post = Post::query()->where('title',$item['title'])->first();
            if($post instanceof Post) {
                $post->ref_id = $topicId;
                $post->save();
                continue;
            }
            //选择一篇转载
            $this->push(new ScrapyImportTopicJob($topicId,$sessionHash,$forumId));
            Log::info('完成转载选择');
            break;
        }
    }
}