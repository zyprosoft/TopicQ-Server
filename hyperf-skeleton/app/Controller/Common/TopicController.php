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
            'title' => 'string|required|min:1|max:24|sensitive',
            'introduce' => 'string|required|min:1|max:128|sensitive',
            'image' => 'string|required|min:1|max:500',
            'categoryId' => 'integer|exists:topic_category,category_id'
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

    public function attention(AuthedRequest $request)
    {
        $this->validate([
            'topicId'=>'integer|required|exists:topic,topic_id',
            'status'=>'integer|required|in:0,1'
        ]);
        $topicId = $request->param('topicId');
        $status = $request->param('status');
        $result = $this->service->attention($topicId,$status);
        return $this->success($result);
    }

    public function getAttentionTopicList(AuthedRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
        ]);
        $pageIndex = $this->request->param('pageIndex');
        $pageSize = $this->request->param('pageSize');
        $result = $this->service->getUserAttentionTopicList($pageIndex,$pageSize);
        return $this->success($result);
    }

    public function getTopicAttentionStatus(AuthedRequest $request)
    {
        $this->validate([
            'topicId'=>'integer|required|exists:topic,topic_id',
        ]);
        $topicId = $request->param('topicId');
        $result = $this->service->getTopicAttentionStatus($topicId);
        return $this->success($result);
    }

    public function getTopicDetail()
    {
        $this->validate([
            'topicId'=>'integer|required|exists:topic,topic_id',
        ]);
        $topicId = $this->request->param('topicId');
        $result = $this->service->getTopicDetail($topicId);
        return $this->success($result);
    }
}