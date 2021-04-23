<?php


namespace App\Service;


use App\Constants\Constants;
use App\Constants\ErrorCode;
use App\Model\Conversation;
use App\Model\PrivateMessage;
use App\Model\User;
use Carbon\Carbon;
use Hyperf\DbConnection\Db;
use ZYProSoft\Exception\HyperfCommonException;
use ZYProSoft\Facade\Auth;
use ZYProSoft\Log\Log;

class PrivateMessageService extends BaseService
{
    //重载获取当前用户ID的方法
    protected function userId()
    {
        //当前用户是不是管理员
        if (Auth::isGuest()) {
            return Auth::userId();
        }
        $userId = Auth::userId();
        $user = User::find($userId);
        if ($user->role_id == Constants::USER_ROLE_ADMIN) {
            //检查是不是在使用化身
            if ($user->avatar_user_id > 0) {
                Log::info("使用化身($user->avatar_user_id)");
                return $user->avatar_user_id;
            }
        }
        return $userId;
    }

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
            }
            if (isset($image)) {
                $conversation->last_message = '[图片]';
                $conversation->last_message_time = Carbon::now()->toDateTimeString();
            }else{
                $conversation->last_message = $message->content;
                $conversation->last_message_time = Carbon::now()->toDateTimeString();
            }
            $conversation->saveOrFail();

            //接收者会话创建
            $toUserConversation = Conversation::query()->where('owner_id', $toUserId)
                ->where('to_user_id', $this->userId())
                ->first();
            if (!$toUserConversation instanceof Conversation) {
                $toUserConversation = new Conversation();
                $toUserConversation->owner_id = $toUserId;
                $toUserConversation->to_user_id = $this->userId();
                $toUserConversation->unread_count = 1;
            }else{
                $toUserConversation->unread_count +=1;
            }
            if (isset($image)) {
                $toUserConversation->last_message = '[图片]';
                $toUserConversation->last_message_time = Carbon::now()->toDateTimeString();
            }else{
                $toUserConversation->last_message = $message->content;
                $toUserConversation->last_message_time = Carbon::now()->toDateTimeString();
            }
            $toUserConversation->saveOrFail();
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
                                     ->orderByDesc('last_message_time')
                                     ->limit($pageSize)
                                     ->get();
        $total = Conversation::query()->where('owner_id', $this->userId())->count();
        return ['total'=>$total, 'list'=>$list];
    }

    public function getList(int $toUserId, int $pageIndex, int $pageSize)
    {
        $userIds = [
            $this->userId(),
            $toUserId,
        ];
        $list = PrivateMessage::query()->whereIn('from_id', $userIds)
                                      ->whereIn('receive_id', $userIds)
                                      ->latest()
                                      ->offset($pageIndex * $pageSize)
                                      ->limit($pageSize)
                                      ->get();
        $total = PrivateMessage::query()->where('from_id', $this->userId())
            ->where('receive_id', $toUserId)
            ->count();
        $idList = $list->where('read_status',Constants::STATUS_WAIT)->pluck('message_id');
        return ['total'=>$total, 'list'=>$list, 'id_list'=>$idList];
    }

    public function markRead(array $idList, int $fromUserId)
    {
        Db::transaction(function () use ($idList,$fromUserId) {

            PrivateMessage::query()->whereIn('message_id', $idList)
                ->where('receive_id', $this->userId())
                ->where('from_id', $fromUserId)
                ->where('read_status',Constants::STATUS_WAIT)
                ->update(['read_status'=>Constants::STATUS_DONE]);

            //更新会话未读数
            $unreadCount = PrivateMessage::query()->where('receive_id', $this->userId())
                ->where('from_id', $fromUserId)
                ->where('read_status',Constants::STATUS_WAIT)
                ->count();

            Conversation::query()->where('owner_id', $this->userId())
                ->where('to_user_id', $fromUserId)
                ->update(['unread_count'=>$unreadCount]);

        });

        return $this->success();
    }

    public function refreshUnreadCountWithFromUser(int $fromUserId)
    {
        Db::transaction(function () use ($fromUserId) {

            //更新会话未读数
            $unreadCount = PrivateMessage::query()->where('receive_id', $this->userId())
                ->where('from_id', $fromUserId)
                ->where('read_status',Constants::STATUS_WAIT)
                ->count();

            Conversation::query()->where('owner_id', $this->userId())
                ->where('to_user_id', $fromUserId)
                ->update(['unread_count'=>$unreadCount]);

        });

        return $this->success();
    }
}