<?php


namespace App\Task;
use App\Service\Scrapy\ImportPostService;
use App\Service\Scrapy\PostService;
use Hyperf\Utils\ApplicationContext;

class AutoDelayPostTask
{
    public function execute()
    {
        $mode = env('SCRAPY_MODE');
        if(isset($mode)) {
            $importService = ApplicationContext::getContainer()->get(ImportPostService::class);
            $importService->getOneTopic();
        }else{{
            $importService = ApplicationContext::getContainer()->get(PostService::class);
            $importService->importTopic();
        }}
    }
}