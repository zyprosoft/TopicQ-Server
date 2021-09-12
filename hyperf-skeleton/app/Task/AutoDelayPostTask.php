<?php


namespace App\Task;
use App\Service\Scrapy\PostService;
use Hyperf\Utils\ApplicationContext;

class AutoDelayPostTask
{
    public function execute()
    {
        //下一个
        $importService = ApplicationContext::getContainer()->get(PostService::class);
        $importService->importTopic();
    }
}