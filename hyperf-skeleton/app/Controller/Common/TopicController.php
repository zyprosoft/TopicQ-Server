<?php


namespace App\Controller\Common;
use App\Service\TopicService;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use ZYProSoft\Http\AuthedRequest;

/**
 * @AutoController (prefix="/common/topic")
 * Class TopicController
 * @package App\Controller\Common
 */
class TopicController extends AbstractController
{
    /**
     * @Inject
     * @var TopicService
     */
    protected TopicService $service;

    public function createTopic(AuthedRequest $request)
    {
        $this->validate([
            'title' => 'string|required|min:1|max:24',
            'introduce' => 'string|required|min:1|max:128',
            'image' => 'string|required|min:1|max:500',
            'categoryId' => 'integer|required|exists:topic_category,category_id'
        ]);
        $params = $request->getParams();
        $result = $this->service->createTopic($params);
        return $this->success($result);
    }

    public function getTopicList()
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
            'keyword' => 'string|min:1|max:24'
        ]);
        $pageIndex = $this->request->param('pageIndex');
        $pageSize = $this->request->param('pageSize');
        $keyword = $this->request->param('keyword');
        $result = $this->service->getTopicList($pageIndex, $pageSize, $keyword);
        return $this->success($result);
    }
}