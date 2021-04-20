<?php


namespace App\Service;


use App\Constants\Constants;
use App\Job\AddNotificationJob;
use App\Model\Comment;
use App\Model\ImageAudit;
use App\Model\Post;
use App\Model\User;
use App\Model\UserUpdate;
use ZYProSoft\Log\Log;

class QiniuAuditService extends BaseService
{
    const AUDIT_SUGGESTION_BLOCK = 'block';

    const AUDIT_SUGGESTION_REVIEW = 'review';

    const AUDIT_SUGGESTION_PASS = 'pass';

    const WARN_MESSAGE_TITLE = '上传图片包含敏感信息警示';

    protected function isSensitive (string $suggestion)
    {
        Log::info("suggestion:$suggestion");
        return $suggestion == self::AUDIT_SUGGESTION_REVIEW || $suggestion == self::AUDIT_SUGGESTION_BLOCK;
    }

    public function checkAuditImageID(string $imageID, array $result)
    {
        Log::info("图片审核结果:" . json_encode($result));
        //解析审核结果
        $isAuditPass = data_get($result, 'disable') == true ? false : true;
        $pulpSuggestion = data_get($result, 'result.scenes.pulp.suggestion');
        $terrorSuggestion = data_get($result, 'result.scenes.terror.suggestion');
        $politicianSuggestion = data_get($result, 'result.scenes.politician.suggestion');
        if ($this->isSensitive($pulpSuggestion) || $this->isSensitive($terrorSuggestion) || $this->isSensitive($politicianSuggestion)) {
            $isAuditPass = false;
        }
        $statusLabel = $isAuditPass ? '通过' : '拒绝';
        $suggestionNote = '七牛回调图片内容审核结果:' . $statusLabel . '  详情:';

        $detailNote = [
            'pulp' => $pulpSuggestion,
            'terror' => $terrorSuggestion,
            'politician' => $politicianSuggestion,
        ];
        $suggestionNote .= json_encode($detailNote);
        Log::info("图片($imageID)审核结果:" . $suggestionNote);

        //创建一条图片审核结果
        $imageAudit = ImageAudit::query()->where('image_id', $imageID)->first();
        if (!$imageAudit instanceof ImageAudit) {
            $imageAudit = new ImageAudit();
        }else{
            //查出归属者信息

        }
    }

    protected function checkPostAuditFinish(int $postId)
    {
        $post = Post::findOrFail($postId);

        //检查帖子的所有图片是否都审核通过
        $auditList = ImageAudit::query()->where('owner_id', $post->post_id)
            ->where('type', Constants::IMAGE_AUDIT_OWNER_POST)
            ->get();
        $isAllValidate = null;
        $auditList->map(function (ImageAudit $audit) use (&$isAllValidate) {
            if($audit->audit_status != Constants::STATUS_DONE) {
                $isAllValidate = false;
            }
        });
        if (!isset($isAllValidate)) {
            Log::error("帖子($postId)仍然有图片未通过审核，不可主动转为审核通过状态");
        }

        //检查内容审核结果

    }

    /**
     * 根据具体场景处理图片审核结果
     * @param int $status
     * @param int $ownerId
     * @param int $ownerType
     */
    protected function dealImageWithStatus(int $status, int $ownerId, int $ownerType)
    {
        switch ($ownerType) {
            case Constants::IMAGE_AUDIT_OWNER_POST:
                {
                    $post = Post::findOrFail($ownerId);
                    $post->machine_audit = $status;
                    //审核不通过
                    if($status == Constants::STATUS_INVALIDATE) {
                        $post->audit_status = $status;
                    }
                    $post->saveOrFail();




                    //帖子审核不通过的提醒
                    if($status == Constants::STATUS_INVALIDATE) {
                        $levelLabel = '警告';
                        $level = Constants::MESSAGE_LEVEL_BLOCK;
                        $title = '帖子审核结果';
                        $statusLabel = $status==Constants::STATUS_DONE?'通过':'拒绝';
                        $content = "您的帖子《{$post->title}》上传图片包含敏感内容，已被管理员审核".$statusLabel;
                        $notification = new AddNotificationJob($post->owner_id,$title,$content,false,$level);
                        $notification->levelLabel = $levelLabel;
                        $notification->keyInfo = json_encode(['post_id'=>$post->post_id]);
                        $this->push($notification);
                    }
                }
                break;
            case Constants::IMAGE_AUDIT_OWNER_COMMENT:
                {
                    $comment = Comment::findOrFail($ownerId);
                    $comment->machine_audit = $status;
                    if($status == Constants::STATUS_INVALIDATE) {
                        $comment->audit_status = $status;
                    }
                    $comment->saveOrFail();
                    //评论审核不通过的提醒
                    if($status == Constants::STATUS_INVALIDATE) {
                        $levelLabel = '警告';
                        $level = Constants::MESSAGE_LEVEL_BLOCK;
                        $title = '帖子审核结果';
                        $statusLabel = $status==Constants::STATUS_DONE?'通过':'拒绝';
                        $content = "您的评论《{$comment->content}》上传图片包含敏感内容，已被管理员审核".$statusLabel;
                        $notification = new AddNotificationJob($comment->owner_id,$title,$content,false,$level);
                        $notification->levelLabel = $levelLabel;
                        $notification->keyInfo = json_encode(['comment_id'=>$comment->comment_id]);
                        $this->push($notification);
                    }
                }
                break;
            case Constants::IMAGE_AUDIT_OWNER_USER:
                {
                    $userUpdate = UserUpdate::findOrFail($ownerId);
                    $userUpdate->machine_audit = $status;
                    $userUpdate->saveOrFail();
                    //如果是审核通过的，那么直接清除用户资料对应的ID,并且更新用户资料
                    if($status == Constants::STATUS_DONE) {
                        $user = User::findOrFail($userUpdate->user_id);
                        if(!empty($userUpdate->avatar)) {

                        }
                        $user->user_update_id = null;
                        $user->saveOrFail();
                    }

                }
                break;
        }
    }
}