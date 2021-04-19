<?php


namespace App\Service;


use App\Constants\Constants;
use App\Model\Notification;

class NotificationService extends BaseService
{
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