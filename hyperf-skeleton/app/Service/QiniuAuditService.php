<?php


namespace App\Service;


use App\Constants\Constants;
use App\Job\AddNotificationJob;
use App\Job\ImageAuditUpdateJob;
use App\Model\Comment;
use App\Model\ImageAudit;
use App\Model\Post;
use App\Model\User;
use App\Model\UserUpdate;
use EasyWeChat\Factory;
use Hyperf\DbConnection\Db;
use ZYProSoft\Log\Log;

class QiniuAuditService extends BaseService
{
    const WX_SECURITY_CHECK_FAIL = 87014;

    const AUDIT_SUGGESTION_BLOCK = 'block';

    const AUDIT_SUGGESTION_REVIEW = 'review';

    const AUDIT_SUGGESTION_PASS = 'pass';

    protected function isSensitive (string $suggestion)
    {
        Log::info("suggestion:$suggestion");
        return $suggestion == self::AUDIT_SUGGESTION_BLOCK;
    }

    protected function isNeedReview (string $suggestion)
    {
        return $suggestion == self::AUDIT_SUGGESTION_REVIEW;
    }

    public function checkAuditImageID(string $imageID, array $result)
    {
        Log::info("图片审核结果:" . json_encode($result));
        //解析审核结果
        $isAuditPass = data_get($result, 'disable') == true ? false : true;
        $pulpSuggestion = data_get($result, 'result.scenes.pulp.suggestion');
        $terrorSuggestion = data_get($result, 'result.scenes.terror.suggestion');
        $politicianSuggestion = data_get($result, 'result.scenes.politician.suggestion');
        $adsSuggestion = data_get($result, 'result.scenes.ads.suggestion');
        $isReview = false;
        if ($this->isSensitive($pulpSuggestion) ||
            $this->isSensitive($terrorSuggestion) ||
            $this->isSensitive($politicianSuggestion) ||
            $this->isSensitive($adsSuggestion)) {
            $isAuditPass = false;
        }
        if($this->isNeedReview($pulpSuggestion) ||
            $this->isNeedReview($terrorSuggestion) ||
            $this->isNeedReview($politicianSuggestion ||
            $this->isNeedReview($adsSuggestion))) {
            $isReview = true;
        }
        $statusLabel = $isAuditPass ? '通过' : '拒绝';
        $suggestionNote = '七牛回调图片内容审核结果:' . $statusLabel . '  详情:';

        $detailNote = [
            'pulp' => $pulpSuggestion,
            'terror' => $terrorSuggestion,
            'politician' => $politicianSuggestion,
            'ads' => $adsSuggestion,
        ];
        $suggestionNote .= json_encode($detailNote);
        Log::info("图片($imageID)审核结果:" . $suggestionNote);

        //创建一条图片审核结果
        $updateStatus = null;
        $imageAudit = null;
        Db::transaction(function () use (&$imageAudit,$isAuditPass,$isReview,$imageID,$suggestionNote,&$updateStatus){
            $imageAudit = ImageAudit::query()->where('image_id', $imageID)->lockForUpdate()->first();
            if (!$imageAudit instanceof ImageAudit) {
                $imageAudit = new ImageAudit();
                $imageAudit->image_id = $imageID;
            }
            //如果审核失败,发送一条提醒
            $updateStatus = Constants::STATUS_DONE;
            if(!$isAuditPass) {
                $updateStatus = Constants::STATUS_INVALIDATE;
            }else{
                if($isReview) {
                    $updateStatus = Constants::STATUS_REVIEW;
                }
            }
            $imageAudit->audit_status = $updateStatus;
            $imageAudit->audit_note = $suggestionNote;
            $imageAudit->saveOrFail();
        });
        if(!isset($updateStatus) || !isset($imageAudit)) {
            Log::error("图片($imageID)审核结果保存失败");
            return;
        }
        Log::info("保存图片($imageID)审核结果($updateStatus)成功!");
        //如果有所有者，更新所有者审核信息
        if(isset($imageAudit->owner_id) && isset($imageAudit->owner_type)) {
            $updateJob = new ImageAuditUpdateJob($imageAudit->owner_id,$imageAudit->owner_type,$updateStatus,$imageID);
            $this->push($updateJob);
        }else{
            Log::info("图片($imageID)没有绑定任何实体信息!");
        }
    }

    public function checkPostAuditFinish(int $postId)
    {
        $post = Post::find($postId);

        if(!$post instanceof Post) {
            Log::error("帖子($postId)不存在!");
            return;
        }

        //帖子是否已经是审核通过状态
        if($post->audit_status == Constants::STATUS_DONE) {
            Log::info("帖子($postId)已经处于审核通过状态");
            return;
        }

        //检查标题审核结果
        if($post->title_audit != Constants::STATUS_DONE) {
            Log::error("帖子($postId)标题未通过审核");
            return;
        }

        //检查内容审核结果
        if($post->content_audit != Constants::STATUS_DONE) {
            Log::error("帖子($postId)内容未通过审核");
            return;
        }

        //检查帖子的所有图片是否都审核通过
        $result = $this->checkImageAllAuditFinish($postId, Constants::IMAGE_AUDIT_OWNER_POST);
        if(!$result) {
            return;
        }

        //更新帖子的审核状态
        $post->audit_status = Constants::STATUS_DONE;
        $post->machine_audit = Constants::STATUS_DONE;
        $result = $post->save();
        if($result == false) {
            Log::info("帖子($postId)完全通过审核，但是更新审核状态保存失败");
            return;
        }

        //帖子完全通过机器审核，发送审核完成的通知
        $level = Constants::MESSAGE_LEVEL_NORMAL;
        $levelLabel = '通知';
        $title = '帖子审核通过';
        $content = "您的帖子《{$post->title}》已被管理员审核通过";

        $notification = new AddNotificationJob($post->owner_id,$title,$content,false,$level);
        $notification->levelLabel = $levelLabel;
        $notification->keyInfo = json_encode(['post_id'=>$postId]);
        $this->push($notification);
    }

    protected function checkCommentAuditFinish(int $commentId)
    {
        $comment = Comment::find($commentId);
        if(!$comment instanceof Comment) {
            Log::info("评论($commentId)不存在!");
            return;
        }

        //评论是否已经是审核通过状态
        if($comment->audit_status == Constants::STATUS_DONE) {
            Log::info("评论($commentId)已经处于审核通过状态");
            return;
        }

        //检查内容审核结果
        if($comment->content_audit != Constants::STATUS_DONE) {
            Log::error("评论($commentId)文本内容未通过审核");
            return;
        }

        //检查评论的所有图片是否都审核通过
        $result = $this->checkImageAllAuditFinish($commentId, Constants::IMAGE_AUDIT_OWNER_COMMENT);
        if(!$result) {
            return;
        }

        //更新评论的审核状态
        $comment->audit_status = Constants::STATUS_DONE;
        $comment->machine_audit = Constants::STATUS_DONE;
        $result = $comment->save();
        if($result == false) {
            Log::info("评论($commentId)完全通过审核，但是更新审核状态保存失败");
            return;
        }
        Log::info("评论($commentId)已完全通过机器审核，无需发送通知!");
    }

    protected function checkImageAllAuditFinish(int $ownerId, int $type)
    {
        $auditList = ImageAudit::query()->where('owner_id', $ownerId)
            ->where('owner_type', $type)
            ->get();
        $map = [
            Constants::IMAGE_AUDIT_OWNER_POST => '帖子',
            Constants::IMAGE_AUDIT_OWNER_COMMENT => '评论',
            Constants::IMAGE_AUDIT_OWNER_USER => '用户资料'
        ];
        $name = $map[$type];
        if($auditList->isEmpty()) {
            Log::info("$name($ownerId)没有包含图片审核信息");
            return true;
        }
        //有图片，检查图片审核状态
        $isAllValidate = true;
        $auditList->map(function (ImageAudit $audit) use (&$isAllValidate) {
            if($audit->audit_status != Constants::STATUS_DONE) {
                $isAllValidate = false;
            }
        });
        if (!$isAllValidate) {
            Log::error("$name($ownerId)仍然有图片未通过审核，不可主动转为审核通过状态");
            return false;
        }
        Log::info("$name($ownerId)图片已经全部通过审核");
        return true;
    }

    protected function checkUserUpdateAuditFinish(int $updateId)
    {
        $userUpdate = UserUpdate::find($updateId);
        if(!$userUpdate instanceof UserUpdate) {
            return;
        }

        //资料审核完全通过的成立条件，头像置空，背景置空，昵称审核通过
        if(isset($userUpdate->nickname) && $userUpdate->nickname_audit == Constants::STATUS_DONE){
            $nicknameAuditStatus = true;
        }else{
            if (!isset($userUpdate->nickname)) {
                $nicknameAuditStatus = true;
            }else{
                $nicknameAuditStatus = false;
            }
        }
        $isAllSuccess = !isset($userUpdate->avatar) && !isset($userUpdate->background) && $nicknameAuditStatus;
        $isReject = $userUpdate->machine_audit == Constants::STATUS_REVIEW || $userUpdate->machine_audit == Constants::STATUS_INVALIDATE;
        //完全通过或者机器审核不通过，都可以清除临时资料
        if($isAllSuccess || $isReject)
        {
            //用户资料已经完全通过审核或者已经被拒绝
            Db::transaction(function () use (&$userUpdate, $updateId) {
                $user = User::query()->where('user_id', $userUpdate->user_id)
                    ->lockForUpdate()
                    ->first();
                if(!$user instanceof User) {
                    Log::info("用户($userUpdate->user_id)不存在!");
                }
                //用户最新的资料ID是不是这个
                if($user->user_update_id != $updateId) {
                    Log::info("用户资料($updateId)已经审核通过，但是用户最新的待更新资料($user->user_update_id)已经变化，无需继续操作!");
                    return;
                }
                $user->user_update_id = null;//设置为空，使用最新信息
                $result = $user->save();
                $resultLabel = $result?'成功':'失败';
                Log::info("用户($user->user_id)资料($updateId)审核通过,更新结果:".$resultLabel);
                Log::info("用户资料($updateId)审核状态更新成功");
            });
        }
    }

    /**
     * 根据具体场景处理图片审核结果
     * @param int $status
     * @param int $ownerId
     * @param int $ownerType
     * @param string $imageID
     */
    public function dealImageWithStatus(int $status, int $ownerId, int $ownerType, string $imageID = null)
    {
        switch ($ownerType) {
            case Constants::IMAGE_AUDIT_OWNER_POST:
                {
                    $post = Post::findOrFail($ownerId);

                    //帖子审核不通过的提醒
                    if($status == Constants::STATUS_INVALIDATE) {
                        //审核不通过
                        $post->audit_status = $status;
                        $post->saveOrFail();
                        $levelLabel = '警告';
                        $level = Constants::MESSAGE_LEVEL_BLOCK;
                        $title = '帖子审核不通过';
                        $statusLabel = $status==Constants::STATUS_DONE?'通过':'拒绝';
                        $content = "您的帖子《{$post->title}》上传图片包含敏感内容，已被管理员审核".$statusLabel;
                        $notification = new AddNotificationJob($post->owner_id,$title,$content,false,$level);
                        $notification->levelLabel = $levelLabel;
                        $notification->keyInfo = json_encode(['post_id'=>$post->post_id]);
                        $this->push($notification);
                        return;
                    }

                    //审核通过状态，检测一下帖子是不是已经完全通过机器审核
                    if($status == Constants::STATUS_DONE) {
                        $this->checkPostAuditFinish($post->post_id);
                    }
                }
                break;
            case Constants::IMAGE_AUDIT_OWNER_COMMENT:
                {
                    $comment = Comment::findOrFail($ownerId);
                    $comment->machine_audit = $status;
                    if($status == Constants::STATUS_INVALIDATE || $status == Constants::STATUS_REVIEW) {
                        $comment->audit_status = $status;
                    }
                    $comment->saveOrFail();
                    //评论审核不通过的提醒,评论不做人工审核，只要疑似敏感都拒绝
                    if($status == Constants::STATUS_INVALIDATE || $status == Constants::STATUS_REVIEW) {
                        $levelLabel = '警告';
                        $level = Constants::MESSAGE_LEVEL_BLOCK;
                        $title = '评论审核不通过';
                        $statusLabel = $status==Constants::STATUS_DONE?'通过':'拒绝';
                        $content = "您的评论《{$comment->content}》上传图片包含敏感内容，已被管理员审核".$statusLabel;
                        $notification = new AddNotificationJob($comment->owner_id,$title,$content,false,$level);
                        $notification->levelLabel = $levelLabel;
                        $notification->keyInfo = json_encode(['comment_id'=>$comment->comment_id]);
                        $this->push($notification);
                        return;
                    }

                    //审核通过，检查是否完全通过审核
                    if($status == Constants::STATUS_DONE) {
                        $this->checkCommentAuditFinish($ownerId);
                    }
                }
                break;
            case Constants::IMAGE_AUDIT_OWNER_USER:
                {
                    $userUpdate = UserUpdate::findOrFail($ownerId);
                    //如果是审核不通过，那么直接清除用户资料对应的ID,使前台继续展示旧资料,用户资料也是，没有人工审核，只要疑似也认为不通过
                    if($status == Constants::STATUS_INVALIDATE || $status == Constants::STATUS_REVIEW) {
                        //审核不通过，清除更新资料ID，恢复到原来的资料显示
                        $userUpdate->machine_audit = $status;
                        $userUpdate->saveOrFail();
                        Log::info("用户资料($ownerId)审核不通过保存成功!");
                        //发送用户资料审核不通过通知
                        if(isset($userUpdate->avatar) && isset($imageID)){
                            $avatarImageID = collect(explode('/', $userUpdate->avatar))->last();
                            if ($avatarImageID == $imageID) {
                                //头像审核不通过
                                $levelLabel = '警告';
                                $level = Constants::MESSAGE_LEVEL_BLOCK;
                                $title = '头像上传审核结果';
                                $content = "您的新头像涉嫌敏感信息，已被管理员审核拒绝";
                                $notification = new AddNotificationJob($userUpdate->user_id,$title,$content,false,$level);
                                $notification->levelLabel = $levelLabel;
                                $this->push($notification);
                            }
                        }
                        if (isset($userUpdate->background) && isset($imageID)) {
                            $backgroundImageID = collect(explode('/', $userUpdate->background))->last();
                            if ($backgroundImageID == $imageID) {
                                //背景审核不通过
                                $levelLabel = '警告';
                                $level = Constants::MESSAGE_LEVEL_BLOCK;
                                $title = '背景上传审核不通过';
                                $content = "您的新背景涉嫌敏感信息，已被管理员审核拒绝";
                                $notification = new AddNotificationJob($userUpdate->user_id,$title,$content,false,$level);
                                $notification->levelLabel = $levelLabel;
                                $this->push($notification);
                            }
                        }
                        return;
                    }

                    //通过审核，可以单独更新用户信息字段
                    if($status == Constants::STATUS_DONE) {
                        //是不是头像
                        if(isset($userUpdate->avatar) && $imageID) {
                            $avatarImageID = collect(explode('/', $userUpdate->avatar))->last();
                            if($avatarImageID == $imageID) {
                                $user = User::findOrFail($userUpdate->user_id);
                                if($user->user_update_id == $userUpdate->update_id) {
                                    $user->avatar = $userUpdate->avatar;
                                    $user->saveOrFail();
                                    $userUpdate->avatar = null;
                                    $userUpdate->saveOrFail();
                                    Log::info("用户资料($ownerId)单独更新头像成功!");
                                }
                            }
                        }
                        //是不是背景
                        if(isset($userUpdate->background) && $imageID) {
                            $backgroundImageID = collect(explode('/', $userUpdate->background))->last();
                            if($backgroundImageID == $imageID) {
                                $user = User::findOrFail($userUpdate->user_id);
                                if($user->user_update_id == $userUpdate->update_id) {
                                    $user->background = $userUpdate->background;
                                    $user->saveOrFail();
                                    $userUpdate->background = null;
                                    $userUpdate->saveOrFail();
                                    Log::info("用户资料($ownerId)单独更新背景成功!");
                                }
                            }
                        }
                    }

                    //检查用户资料是否已经完成审核
                    if($status == Constants::STATUS_DONE) {
                        $this->checkUserUpdateAuditFinish($ownerId);
                    }
                }
                break;
        }
    }

    protected function addPostAuditFailNotification(int $postId, string $postTitle, int $userId, string $reason)
    {
        $levelLabel = '警告';
        $level = Constants::MESSAGE_LEVEL_BLOCK;
        $title = '帖子审核不通过';
        $content = "您的帖子《{$postTitle}》{$reason}，已被管理员审核拒绝";
        $notification = new AddNotificationJob($userId,$title,$content,false,$level);
        $notification->levelLabel = $levelLabel;
        $notification->keyInfo = json_encode(['post_id'=>$postId]);
        $this->push($notification);
    }

    public function auditPost(int $postId)
    {
        $post = Post::find($postId);
        if(!$post instanceof Post) {
            Log::info("帖子($postId)不存在");
            return;
        }
        $miniProgramConfig = config('weixin.miniProgram');
        $app = Factory::miniProgram($miniProgramConfig);

        //标题审核
        $result = $app->content_security->checkText($post->title);
        Log::info("微信帖子标题审核结果:".json_encode($result));
        //包含敏感信息
        if(data_get($result,'errcode') == self::WX_SECURITY_CHECK_FAIL) {
            $post->title_audit = Constants::STATUS_INVALIDATE;
            $post->machine_audit = Constants::STATUS_INVALIDATE;
            $post->audit_status = Constants::STATUS_INVALIDATE;
            $post->saveOrFail();
            //发送一条审核不通过的通知
            $this->addPostAuditFailNotification($postId,$post->title,$post->owner_id,'标题包含敏感信息');
            return;
        }

        //标题审核通过
        $post->title_audit = Constants::STATUS_DONE;

        //内容审核
        $result = $app->content_security->checkText($post->content);
        Log::info("微信帖子内容审核结果:".json_encode($result));
        //包含敏感信息
        if(data_get($result,'errcode') == self::WX_SECURITY_CHECK_FAIL) {
            $post->content_audit = Constants::STATUS_INVALIDATE;
            $post->machine_audit = Constants::STATUS_INVALIDATE;
            $post->audit_status = Constants::STATUS_INVALIDATE;
            $post->saveOrFail();
            //发送一条审核不通过的通知
            $this->addPostAuditFailNotification($postId,$post->title,$post->owner_id,'主题内容包含敏感信息');
            return;
        }

        //内容审核通过
        $post->content_audit = Constants::STATUS_DONE;
        $post->saveOrFail();

        //审核都通过，检查一下帖子是不是全部审核完成
        $this->checkPostAuditFinish($postId);
    }

    public function auditComment(int $commentId)
    {
        $comment = Comment::find($commentId);
        if(!$comment instanceof Comment) {
            Log::info("评论($commentId)不存在");
            return;
        }
        $miniProgramConfig = config('weixin.miniProgram');
        $app = Factory::miniProgram($miniProgramConfig);
        $result = $app->content_security->checkText($comment->content);
        Log::info("微信评论审核结果:".json_encode($result));
        if(data_get($result,'errcode') == self::WX_SECURITY_CHECK_FAIL) {
            $comment->machine_audit = Constants::STATUS_INVALIDATE;
            $comment->content_audit = Constants::STATUS_INVALIDATE;
            $comment->audit_status = Constants::STATUS_INVALIDATE;
            $comment->saveOrFail();
            //发送一条审核不通过通知
            $levelLabel = '警告';
            $level = Constants::MESSAGE_LEVEL_BLOCK;
            $title = '评论审核不通过';
            $content = "您的评论《{$comment->content}》内容包含敏感信息，已被管理员审核拒绝";
            $notification = new AddNotificationJob($comment->owner_id,$title,$content,false,$level);
            $notification->levelLabel = $levelLabel;
            $notification->keyInfo = json_encode(['comment_id'=>$commentId]);
            $this->push($notification);
            return;
        }
        $comment->content_audit = Constants::STATUS_DONE;
        $comment->saveOrFail();

        //审核通过，尝试确认帖子是不是完全审核完成
        $this->checkCommentAuditFinish($commentId);
    }

    public function auditUserUpdate(int $updateId)
    {
        $userUpdate = UserUpdate::find($updateId);
        if(!$userUpdate instanceof UserUpdate) {
            Log::info("用户更新资料($updateId)不存在");
            return;
        }
        if(!isset($userUpdate->nickname)) {
            Log::info("用户资料更新($updateId)未更新昵称!");
            //检查一下是不是已经处于完成审核状态
            $this->checkUserUpdateAuditFinish($updateId);
            return;
        }
        //检查昵称是否通过审核
        $miniProgramConfig = config('weixin.miniProgram');
        $app = Factory::miniProgram($miniProgramConfig);
        $result = $app->content_security->checkText($userUpdate->nickname);
        Log::info("{$userUpdate->nickname}微信昵称审核结果:".json_encode($result));
        if(data_get($result,'errcode') == self::WX_SECURITY_CHECK_FAIL) {
            $userUpdate->machine_audit = Constants::STATUS_INVALIDATE;
            $user = User::find($userUpdate->user_id);
            $user->user_update_id = null;
            $user->saveOrFail();
            $userUpdate->saveOrFail();
            //发送一条通知
            $levelLabel = '警告';
            $level = Constants::MESSAGE_LEVEL_BLOCK;
            $title = '资料修改审核不通过';
            $content = "您的用户资料更新:昵称《{$userUpdate->nickname}》 包含敏感信息，已被管理员审核拒绝";
            $notification = new AddNotificationJob($userUpdate->user_id,$title,$content,false,$level);
            $notification->levelLabel = $levelLabel;
            $notification->keyInfo = json_encode(['update_id'=>$updateId]);
            $this->push($notification);
            return;
        }
        //昵称通过就修改昵称
        $user = User::find($userUpdate->user_id);
        $user->nickname = $userUpdate->nickname;
        $user->saveOrFail();
        $userUpdate->nickname_audit = Constants::STATUS_DONE;
        $userUpdate->saveOrFail();
        Log::info("用户({$user->user_id})昵称更新成功,无需通知!");
        //检查一下是不是已经处于完成审核状态
        $this->checkUserUpdateAuditFinish($updateId);
    }
}