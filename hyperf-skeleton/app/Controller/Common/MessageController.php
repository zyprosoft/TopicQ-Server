<?php


namespace App\Controller\Common;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\PrivateMessageService;
use ZYProSoft\Http\AuthedRequest;

/**
 * @AutoController (prefix="/common/message")
 * Class MessageController
 * @package App\Controller\Common
 */
class MessageController extends AbstractController
{
    /**
     * @Inject
     * @var PrivateMessageService
     */
    private PrivateMessageService $service;

    public function create(AuthedRequest $request)
    {
        $this->validate([
            'toUserId' => 'integer|required|exists:user,user_id',
            'content' => 'string|min:1|max:500|sensitive',
            'image' => 'string|min:1|max:500'
        ]);
        $toUserId = $request->param('toUserId');
        $content = $request->param('content');
        $image = $request->param('image');
        $result = $this->service->create($toUserId, $content, $image);
        return $this->success($result);
    }

    public function conversationList(AuthedRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:1|max:30'
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $result = $this->service->getConversationList($pageIndex, $pageSize);
        return $this->success($result);
    }

    public function list(AuthedRequest $request)
    {
        $this->validate([
            'toUserId' => 'integer|required|exists:user,user_id',
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:1|max:30'
        ]);
        $toUserId = $request->param('toUserId');
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $result = $this->service->getList($toUserId, $pageIndex, $pageSize);
        return $this->success($result);
    }

    public function markRead(AuthedRequest $request)
    {
        $this->validate([
            'messageIds' => 'array|required|min:1',
            'fromUserId' => 'integer|required|exists:user,user_id'
        ]);
        $messageIds = $request->param('messageIds');
        $fromUserId = $request->param('fromUserId');
        $result = $this->service->markRead($messageIds, $fromUserId);
        return $this->success($result);
    }

    public function refreshUnreadMessage(AuthedRequest $request)
    {
        $this->validate([
            'fromUserId' => 'integer|required|exists:user,user_id'
        ]);
        $fromUserId = $request->param('fromUserId');
        $result = $this->service->refreshUnreadCountWithFromUser($fromUserId);
        return $this->success($result);
    }
}