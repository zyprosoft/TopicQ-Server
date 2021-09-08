<?php


namespace App\Job;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Hyperf\AsyncQueue\Job;
use Hyperf\Guzzle\CoroutineHandler;
use Hyperf\Utils\ApplicationContext;
use Swoole\Coroutine;
use ZYProSoft\Log\Log;

class ScrapyImportTopicJob extends Job
{
    protected string $baseUrl = 'https://weixin.libaclub.com/weChatService/interface.php?act=get_reply_info&page=1';

    protected string $topicId;

    protected string $sessionHash;

    /**
     * 初始化client的配置
     * @var array
     */
    protected $options = [];

    /**
     * @var Client
     */
    protected $client;

    public function __construct(string $topicId, string $sessionHash)
    {
        $this->topicId = $topicId;
        $this->sessionHash = $sessionHash;
        $stack = null;
        if (Coroutine::getCid() > 0) {
            $stack = HandlerStack::create(new CoroutineHandler());
        }
        $config = array_replace(['handler' => $stack], $this->options);
        $this->client = ApplicationContext::getContainer()->make(Client::class, ['config' => $config]);

    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        $url = $this->baseUrl.'&topic_id='.$this->topicId.'&sessionhash='.$this->sessionHash;
        $result = $this->client->get($url);
        Log::info('抓取帖子详情结果:'.$result->getBody());
    }
}