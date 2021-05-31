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
        $result = $this->service->getActivityList();
        return $this->success($result);
    }
}