<?php


namespace App\Controller\Common;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\ActivityService;

/**
 * @AutoController (prefix="/common/activity")
 * Class ActivityController
 * @package App\Controller\Common
 */
class ActivityController extends AbstractController
{
    /**
     * @Inject
     * @var ActivityService
     */
    protected ActivityService $service;

    public function getActivityList()
    {
        $this->validate([
            'type' => 'integer',
            'forumId' => 'integer|exists:forum,forum_id'
        ]);
        $type = $this->request->param('type');
        $forumId = $this->request->param('forumId');
        $result = $this->service->getActivityList($type,$forumId);
        return $this->success($result);
    }

    public function getIndexConfigData()
    {
        $result = $this->service->getIndexConfigData();
        return $this->success($result);
    }
}