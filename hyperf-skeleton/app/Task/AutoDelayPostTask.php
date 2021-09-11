<?php


namespace App\Task;

use App\Job\ScrapyImportTopicJob;
use App\Model\Forum;
use App\Model\ManagerAvatarUser;
use App\Model\Post;
use App\Service\Scrapy\PostService;
use Hyperf\AsyncQueue\Driver\DriverFactory;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Utils\Str;
use ZYProSoft\Log\Log;

class AutoDelayPostTask
{
    public function execute()
    {
        //下一个
        $importService = ApplicationContext::getContainer()->get(PostService::class);
        $importService->importTopic();
    }
}