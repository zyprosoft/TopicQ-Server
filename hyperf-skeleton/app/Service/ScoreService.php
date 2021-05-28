<?php


namespace App\Service;

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
        $list = UserScoreDetail::query()->where('owner_id',$this->userId())
                                        ->offset($pageIndex * $pageSize)
                                        ->limit($pageSize)
                                        ->get();
        $total = UserScoreDetail::query()->where('owner_id',$this->userId())->count();
        return ['total'=>$total,'list'=>$list];
    }

    public function addScore(int $userId, string $bindAction, string $desc)
    {
        Db::transaction(function () use ($userId, $bindAction, $desc){
            $action = ScoreAction::query()->where('bind_action',$bindAction)->first();
            if (!$action instanceof ScoreAction) {
                throw new HyperfCommonException(ErrorCode::RECORD_NOT_EXIST);
            }
            //行为是否触发了每日最大限制
            if ($action->day_max_times > 0) {
                $today = Carbon::now()->toDateString();
                $count = UserScoreDetail::query()->where('owner_id',$userId)
                    ->where('bind_action',$bindAction)
                    ->whereDate('created_at',$today)
                    ->count();
                if($count >= $action->day_max_times) {
                    Log::info("用户($userId)行为($bindAction)已经触发当日最大加分次数($action->day_max_times)");
                    return;
                }
            }
            $user = User::query()->select(['score'])->where('user_id',$userId)->lockForUpdate()->first();
            if (!$user instanceof User) {
                throw new HyperfCommonException(ErrorCode::RECORD_NOT_EXIST);
            }
            $user->increment('score',$action->score);
            $detail = new UserScoreDetail();
            $detail->bind_action = $bindAction;
            $detail->owner_id = $userId;
            $detail->score = $action->score;
            $detail->desc = $desc;
            $detail->saveOrFail();
        });
    }
}