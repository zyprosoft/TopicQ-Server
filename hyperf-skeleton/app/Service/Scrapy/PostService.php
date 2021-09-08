<?php


namespace App\Service\Scrapy;

use App\Job\ScrapyImportTopicJob;
use App\Model\DelayPostTask;
use App\Model\Scrapy\Comment;
use App\Model\Scrapy\Post;
use App\Model\Scrapy\Thread;
use App\Service\BaseService;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Hyperf\Database\Model\Builder;
use Hyperf\Guzzle\CoroutineHandler;
use Hyperf\Utils\ApplicationContext;
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
}