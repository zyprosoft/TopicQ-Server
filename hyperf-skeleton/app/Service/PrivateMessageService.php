<?php


namespace App\Service;


use App\Constants\Constants;
use App\Constants\ErrorCode;
use App\Model\Conversation;
use App\Model\PrivateMessage;
use Hyperf\DbConnection\Db;
use ZYProSoft\Exception\HyperfCommonException;

class PrivateMessageService extends BaseService
{
    public function create(int $toUserId, string $content = null, string $image = null)
    {
        $message = null;
        Db::transaction(function () use ($toUserId, $content, $image, &$message) {

            $message = new PrivateMessage();
            $message->receive_id = $toUserId;
            $message->from_id = $this->userId();
            if (isset($image)) {
                $message->image = $image;
            }
            if (isset($content)) {
                $message->content = $content;
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
                if (isset($image)) {
                    $conversation->last_message = '[图片]';
                }else{
                    $conversation->last_message = $message->content;
                }
                $conversation->saveOrFail();
            }

            //接收者会话创建
            $toUserConversation = Conversation::query()->where('owner_id', $toUserId)
                ->where('to_user_id', $this->userId())
                ->first();
            if (!$toUserConversation instanceof Conversation) {
                $toUserConversation = new Conversation();
                $toUserConversation->owner_id = $toUserId;
                $toUserConversation->to_user_id = $this->userId();
                if (isset($image)) {
                    $toUserConversation->last_message = '[图片]';
                }else{
                    $toUserConversation->last_message = $message->content;
                }
                $toUserConversation->unread_count = 1;
                $toUserConversation->saveOrFail();
            }else{
                $toUserConversation->increment('unread_count');
            }

        });

        if (!$message instanceof PrivateMessage) {
            throw new HyperfCommonException(ErrorCode::SERVER_ERROR);
        }

        //获取完整数据
        $message = PrivateMessage::findOrFail($message->message_id);

        return $this->success($message);
    }

    public function getConversationList(int $pageIndex, int $pageSize)
    {
        $list = Conversation::query()->where('owner_id', $this->userId())
                                     ->offset($pageIndex * $pageSize)
                                     ->limit($pageSize)
                                     ->get();
        $total = Conversation::query()->where('owner_id', $this->userId())->count();
        return ['total'=>$total, 'list'=>$list];
    }

    public function getList(int $toUserId, int $pageIndex, int $pageSize)
    {
        $list = PrivateMessage::query()->where('from_id', $this->userId())
                                      ->where('receive_id', $toUserId)
                                      ->latest()
                                      ->offset($pageIndex * $pageSize)
                                      ->limit($pageSize)
                                      ->get();
        $total = PrivateMessage::query()->where('from_id', $this->userId())
            ->where('receive_id', $toUserId)
            ->count();
        $idList = $list->pluck('message_id');
        return ['total'=>$total, 'list'=>$list, 'id_list'=>$idList];
    }

    public function markRead(array $idList, int $fromUserId)
    {
        Db::transaction(function () use ($idList,$fromUserId) {

            PrivateMessage::query()->whereIn('message_id', $idList)
                ->where('receive_id', $this->userId())
                ->where('from_id', $fromUserId)
                ->where('is_read',Constants::STATUS_WAIT)
                ->update(['is_read'=>Constants::STATUS_DONE]);

            //更新会话未读数
            $unreadCount = PrivateMessage::query()->where('receive_id', $this->userId())
                ->where('from_id', $fromUserId)
                ->where('is_read',Constants::STATUS_WAIT)
                ->count();

            Conversation::query()->where('owner_id', $this->userId())
                ->where('to_user_id', $fromUserId)
                ->update(['unread_count'=>$unreadCount]);

        });

        return $this->success();
    }
}