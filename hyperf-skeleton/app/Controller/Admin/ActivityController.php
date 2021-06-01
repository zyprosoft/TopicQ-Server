<?php


namespace App\Controller\Admin;
use App\Http\AppAdminRequest;
use App\Service\Admin\ActivityService;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;

/**
 * @AutoController (prefix="/admin/activity")
 * Class ActivityController
 * @package App\Controller\Admin
 */
class ActivityController extends AbstractController
{
    /**
     * @Inject
     * @var ActivityService
     */
    protected ActivityService $service;

    public function createOrUpdate(AppAdminRequest $request)
    {
        $this->validate([
            'title' => 'string|required|min:1|max:24',
            'introduce' => 'string|min:1|max:64',
            'image' => 'string|min:1|max:256',
            'postId' => 'integer|exists:post,post_id',
            'jumpPath' => 'string|min:1',
            'jumpUrl' => 'string|min:1'
        ]);
        $params = $request->getParams();
        $result = $this->service->createOrUpdate($params);
        return $this->success($result);
    }

    public function createOrSyncFromPost(AppAdminRequest $request)
    {
        $this->validate([
            'postId' => 'integer|required|exists:post,post_id'
        ]);
        $postId = $request->param('postId');
        $result = $this->service->createOrSyncFromPost($postId);
        return $this->success($result);
    }

    public function sort(AppAdminRequest $request)
    {
        $this->validate([
            'activityId' => 'integer|required|exists:activity,activity_id',
            'isUp' => 'integer|required|in:0,1'
        ]);
        $activityId = $request->param('activityId');
        $isUp = $request->param('isUp');
        $result = $this->service->sort($activityId,$isUp);
        return $this->success($result);
    }

    public function changeStatus(AppAdminRequest $request)
    {
        $this->validate([
            'activityId' => 'integer|required|exists:activity,activity_id',
            'status' => 'integer|required|in:0,-1'
        ]);
        $activityId = $request->param('activityId');
        $status = $request->param('status');
        $result = $this->service->changeStatus($activityId,$status);
        return $this->success($result);
    }

    public function getActivityList()
    {
        $result = $this->service->getActivityList();
        return $this->success($result);
    }
}