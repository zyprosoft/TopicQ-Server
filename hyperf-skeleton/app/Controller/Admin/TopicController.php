<?php


namespace App\Controller\Admin;
use App\Http\AppAdminRequest;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\Admin\TopicService;

/**
 * @AutoController (prefix="/admin/topic")
 * Class TopicController
 * @package App\Controller\Admin
 */
class TopicController extends AbstractController
{
    /**
     * @Inject
     * @var TopicService
     */
    protected TopicService $service;

    public function getTopicList(AppAdminRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30'
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $result = $this->service->getTopicList($pageIndex,$pageSize);
        return $this->success($result);
    }

    public function getWaitAuditTopicList(AppAdminRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
            'lastTopicId' => 'integer|exists:topic,topic_id'
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $topicId = $request->param('topicId');
        $result = $this->service->getWaitAuditTopicList($pageIndex,$pageSize,$topicId);
        return $this->success($result);
    }

    public function hiddenTopic(AppAdminRequest $request)
    {
        $this->validate([
            'topicId' => 'integer|required|exists:topic,topic_id',
            'status' => 'integer|required|in:0,1'
        ]);
        $topicId = $request->param('topicId');
        $status = $request->param('status');
        $result = $this->service->hiddenTopic($status,$topicId);
        return $this->success($result);
    }

    public function auditTopic(AppAdminRequest $request)
    {
        $this->validate([
            'topicId' => 'integer|required|exists:topic,topic_id',
            'status' => 'integer|required|in:-1,1,2'
        ]);
        $topicId = $request->param('topicId');
        $status = $request->param('status');
        $result = $this->service->auditTopic($status,$topicId);
        return $this->success($result);
    }

    public function getMaxRecommendWeight(AppAdminRequest $request)
    {
        $result = $this->service->getMaxRecommendWeight();
        return $this->success($result);
    }

    public function updateTopicRecommendWeight(AppAdminRequest $request)
    {
        $this->validate([
            'topicId' => 'integer|required|exists:topic,topic_id',
            'weight' => 'integer|required|min:0'
        ]);
        $topicId = $request->param('topicId');
        $weight = $request->param('weight');
        $result = $this->service->updateRecommendWeight($topicId,$weight);
        return $this->success($result);
    }
}