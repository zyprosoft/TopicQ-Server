<?php


namespace App\Task;
use App\Constants\Constants;
use App\Service\Scrapy\ImportPostService;
use App\Service\Scrapy\PostService;
use Hyperf\Utils\ApplicationContext;

class AutoDelayPostTask
{
    public function execute()
    {
        $enableScrapy = env('SCRAPY_ENABLE');
        if (isset($enableScrapy) && $enableScrapy == Constants::STATUS_OK) {
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
}