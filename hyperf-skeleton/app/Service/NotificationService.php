<?php


namespace App\Service;


use App\Constants\Constants;
use App\Model\ManagerAvatarUser;
use App\Model\Notification;
use App\Model\User;
use ZYProSoft\Facade\Auth;
use ZYProSoft\Log\Log;

class NotificationService extends BaseService
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
        if ($user->role_id <= Constants::USER_ROLE_SUB_ADMIN) {
            //检查是不是在使用化身
            if ($user->avatar_user_id > 0) {
                Log::info("使用化身($user->avatar_user_id)");
                return $user->avatar_user_id;
            }
        }
        return $userId;
    }

    public function create(int $userId, string $title, string $content, bool $isTop = false, int $level = Constants::MESSAGE_LEVEL_NORMAL, string $levelLabel = null, string $keyInfo=null)
    {
        $message = new Notification();
        $message->user_id = $userId;
        $message->title = $title;
        $message->content = $content;
        $message->is_top = $isTop;
        $message->level = $level;
        if (!empty($levelLabel)) {
            $message->level_label = $levelLabel;
        }
        if (!empty($keyInfo)) {
            $message->key_info = $keyInfo;
        }

        $message->saveOrFail();

        return $this->success($message);
    }

    public function markRead(array $messageIds)
    {
        Notification::query()->whereIn('message_id', $messageIds)
            ->where('user_id', $this->userId())
            ->update([
                'is_read' => Constants::STATUS_DONE,
            ]);

        return $this->success();
    }

    public function list(int $pageIndex, int $pageSize)
    {
        $list = Notification::query()->where('user_id', $this->userId())
            ->orderByDesc('is_top')
            ->orderBy('is_read')
            ->orderByDesc('created_at')
            ->offset( $pageIndex * $pageSize)
            ->limit($pageSize)
            ->get();
        $total = Notification::query()->where('user_id', $this->userId())
            ->count();
        $idList = $list->where('is_read',Constants::STATUS_WAIT)->pluck('message_id');

        return [
            'total' => $total,
            'list' => $list,
            'unread_id_list' => $idList
        ];
    }
}