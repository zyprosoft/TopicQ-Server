<?php


namespace App\Controller\Common;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\NotificationService;
use ZYProSoft\Http\AuthedRequest;

/**
 * @AutoController (prefix="/common/notification")
 * Class NotificationController
 * @package App\Controller\Common
 */
class NotificationController extends AbstractController
{
    /**
     * @Inject
     * @var NotificationService
     */
    protected NotificationService $service;

    public function list(AuthedRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $result = $this->service->list($pageIndex, $pageSize);
        return $this->success($result);
    }

    public function markRead(AuthedRequest $request)
    {
        $this->validate([
            'messageIds' => 'array|required|min:1',
        ]);
        $messageIds = $request->param('messageIds');
        $result = $this->service->markRead($messageIds);
        return $this->success($result);
    }
}