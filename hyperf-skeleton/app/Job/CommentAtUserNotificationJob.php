<?php


namespace App\Job;


use App\Constants\Constants;
use App\Model\Comment;
use App\Model\CommentAtUser;
use App\Model\User;
use App\Service\NotificationService;
use Hyperf\Utils\ApplicationContext;
use ZYProSoft\Log\Log;

class CommentAtUserNotificationJob extends \Hyperf\AsyncQueue\Job
{
    public int $commentId;

    public array $atUserIds;

    public function __construct(int $commentId, array $atUserIds)
    {
        $this->commentId = $commentId;
        $this->atUserIds = $atUserIds;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        $comment = Comment::findOrFail($this->commentId);
        $userList = User::findMany($this->atUserIds);
        $notificationService = ApplicationContext::getContainer()->get(NotificationService::class);
        //给每个用户发送信息
        $userList->map(function (User $user) use ($comment,$notificationService){
           //
            $title = $comment->author->nickname."在评论中@了你";
            $commentAtUserString = '';
            $comment->at_user_list->map(function (CommentAtUser $atUser) use(&$commentAtUserString) {
                $commentAtUserString .= "@".$atUser->author->nickname."  ";
            });
            $content = "\"".$comment->content."\"".$commentAtUserString;
            $level = Constants::MESSAGE_LEVEL_WARN;
            $levelLabel = "提醒";
            $keyInfo = [
                'comment_id' => $comment->comment_id,
            ];
            $notificationService->create($user->user_id,$title,$content,false,$level,$levelLabel,json_encode($keyInfo));
        });
        Log::info("完成评论({$this->commentId})@异步通知!");
    }
}