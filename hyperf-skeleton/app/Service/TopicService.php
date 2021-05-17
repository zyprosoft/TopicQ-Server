<?php


namespace App\Service;
use App\Model\Topic;
use App\Model\TopicCategory;
use ZYProSoft\Constants\ErrorCode;
use ZYProSoft\Exception\HyperfCommonException;
use ZYProSoft\Service\AbstractService;

class TopicService extends AbstractService
{
    public function createCategory(string $name)
    {
        $category = TopicCategory::query()->where('name',$name)->first();
        if ($category instanceof TopicCategory) {
            throw new HyperfCommonException(ErrorCode::RECORD_DID_EXIST);
        }
        $category = new TopicCategory();
        $category->name = $name;
        $category->saveOrFail();
        return $category;
    }

    public function createTopic(array $params)
    {

    }

    public function getTopicList()
    {
        
    }
}