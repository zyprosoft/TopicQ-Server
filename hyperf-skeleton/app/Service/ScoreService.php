<?php


namespace App\Service;

use App\Model\ScoreAction;
use App\Model\User;
use Hyperf\DbConnection\Db;
use ZYProSoft\Constants\ErrorCode;
use ZYProSoft\Exception\HyperfCommonException;

class ScoreService extends BaseService
{
    public function addScore(int $userId, string $bindAction)
    {
        Db::transaction(function () use ($userId, $bindAction){
            $action = ScoreAction::query()->where('bind_action',$bindAction)->first();
            if (!$action instanceof ScoreAction) {
                throw new HyperfCommonException(ErrorCode::RECORD_NOT_EXIST);
            }
            $user = User::query()->select(['score'])->where('user_id',$userId)->lockForUpdate()->first();
            if (!$user instanceof User) {
                throw new HyperfCommonException(ErrorCode::RECORD_NOT_EXIST);
            }
            $user->score += $action->score;
            $user->saveOrFail();
        });
    }
}