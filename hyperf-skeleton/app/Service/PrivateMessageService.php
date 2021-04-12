<?php


namespace App\Service;


use App\Model\Conversation;
use App\Model\PrivateMessage;
use Hyperf\DbConnection\Db;

class PrivateMessageService extends BaseService
{
    public function create(int $toUserId, string $content, string $image = null)
    {
        Db::transaction(function () use ($toUserId, $content, $image) {
            $message = new PrivateMessage();
            $message->receive_id = $toUserId;
            $message->from_id = $this->userId();
            $message->content = $content;
            if (isset($image)) {
                $message->image = $image;
            }
            $message->saveOrFail();

            //会话是否存在
            $conversation = Conversation::query()->where('owner_id', $this->userId())
                ->where('to_user_id', $toUserId)
                ->first();
            if (!$conversation instanceof Conversation) {
                $conversation = new Conversation();
                $conversation->owner_id = $this->userId();
                $conversation->to_user_id = $toUserId;
                $conversation->unread_count = 1;
                $conversation->saveOrFail();
            }else{
                $conversation->increment('unread_count');
            }
        });

        return $this->success();
    }

    public function getList(int $conversationId, int $pageIndex, int $pageSize)
    {

    }
}