<?php


namespace App\Service;

use App\Model\Post;
use App\Model\PostScoreReward;
use App\Model\ScoreAction;
use App\Model\User;
use App\Model\UserScoreDetail;
use Carbon\Carbon;
use Hyperf\DbConnection\Db;
use ZYProSoft\Constants\ErrorCode;
use ZYProSoft\Exception\HyperfCommonException;
use ZYProSoft\Log\Log;

class ScoreService extends BaseService
{
    public function getScoreDetailList(int $pageIndex, int $pageSize)
    {
        $list = UserScoreDetail::query()->where('owner_id', $this->userId())
            ->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->latest()
            ->get();
        $total = UserScoreDetail::query()->where('owner_id', $this->userId())->count();
        return ['total' => $total, 'list' => $list];
    }

    public function addScore(int $userId, string $bindAction, string $desc)
    {
        Db::transaction(function () use ($userId, $bindAction, $desc) {
            Log::info("开始处理用户($userId)增加积分行为$bindAction");
            $action = ScoreAction::query()->where('bind_action', $bindAction)->first();
            if (!$action instanceof ScoreAction) {
                throw new HyperfCommonException(ErrorCode::RECORD_NOT_EXIST);
            }
            //行为是否触发了每日最大限制
            if ($action->day_max_times > 0) {
                $today = Carbon::now()->toDateString();
                $count = UserScoreDetail::query()->where('owner_id', $userId)
                    ->where('bind_action', $bindAction)
                    ->whereDate('created_at', $today)
                    ->count();
                if ($count >= $action->day_max_times) {
                    Log::info("用户($userId)行为($bindAction)已经触发当日最大加分次数($action->day_max_times)");
                    return;
                }
            }
            $user = User::query()->select(['score', 'user_id'])->where('user_id', $userId)->lockForUpdate()->first();
            if (!$user instanceof User) {
                throw new HyperfCommonException(ErrorCode::RECORD_NOT_EXIST);
            }
            $user->increment('score', $action->score);
            $detail = new UserScoreDetail();
            $detail->bind_action = $bindAction;
            $detail->owner_id = $userId;
            $detail->score = $action->score;
            $detail->desc = $desc;
            $detail->saveOrFail();
        });
    }

    public function reward(int $otherUserId, int $score)
    {
        Db::transaction(function () use ($otherUserId, $score) {
            $self = User::query()->where('user_id', $this->userId())
                ->lockForUpdate()
                ->first();
            if(!$self instanceof User) {
                throw new HyperfCommonException(ErrorCode::RECORD_NOT_EXIST);
            }
            $other = User::query()->where('user_id', $otherUserId)
                ->lockForUpdate()
                ->first();
            if(!$other instanceof User) {
                throw new HyperfCommonException(ErrorCode::RECORD_NOT_EXIST);
            }
            if($self->score < $score) {
                throw new HyperfCommonException(\App\Constants\ErrorCode::SCORE_PAY_NOT_ENOUGH);
            }
            $self->decrement('score',$score);
            $other->increment('score',$score);
        });
        return $this->success();
    }

    public function rewardPost(int $postId, int $score)
    {
        Db::transaction(function () use ($postId,$score){

            $post = Post::findOrFail($postId);
            $user = User::findOrFail($this->userId());
            if($user->score < $score) {
                throw new HyperfCommonException(\App\Constants\ErrorCode::SCORE_PAY_NOT_ENOUGH);
            }

            //用户是否已经打赏过
            $rewardRecord = PostScoreReward::query()->where('post_id',$postId)
                ->where('user_id',$user->user_id)
                ->first();
            if(!$rewardRecord instanceof PostScoreReward) {
                $rewardRecord = new PostScoreReward();
                $rewardRecord->post_id = $postId;
                $rewardRecord->post_owner_id = $post->post_id;
                $rewardRecord->user_id = $user->user_id;
            }
            $rewardRecord->amount += $score;
            $user->score -= $score;
            $rewardRecord->saveOrFail();
            $user->saveOrFail();
        });
        return $this->success();
    }

    public function getPostRewardUser(int $postId)
    {

    }
}