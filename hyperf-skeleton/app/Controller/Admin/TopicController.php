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