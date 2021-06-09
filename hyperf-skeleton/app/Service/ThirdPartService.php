<?php


namespace App\Service;


use App\Constants\Constants;
use App\Model\MiniProgram;
use App\Model\MiniProgramCategory;
use App\Model\OfficialAccount;
use App\Model\OfficialAccountCategory;
use App\Model\QqMiniProgram;
use App\Model\UserMiniProgramUse;
use App\Model\UserOfficialAccountUse;
use App\Model\UserThirdPartUse;
use ZYProSoft\Constants\ErrorCode;
use ZYProSoft\Exception\HyperfCommonException;

class ThirdPartService extends BaseService
{
    const MINI_PROGRAM_BASE_ALWAYS_USE_COUNT = 3;

    public function getAllMiniProgram(bool $byCategory = false, string $type = null)
    {
        if (!isset($type)) {
            $type = 'weixin';
        }
        if ($type == 'qq' ) {
            if ($byCategory) {
                return QqMiniProgram::all();
            }
            return  MiniProgramCategory::query()->with(['qq_mini_items'])->get();
        }
        $list = MiniProgram::all();
        if ($byCategory == false) {
            return $list;
        }
        return MiniProgramCategory::query()->with(['items'])->get();
    }

    public function getAllOfficialAccount(bool $byCategory = false)
    {
        $list = OfficialAccount::all();
        if ($byCategory == false) {
            return $list;
        }
        return OfficialAccountCategory::query()->with(['items'])->get();
    }

    public function markMiniProgramUsed(string $programId, string $type = 'weixin')
    {
        $useRecord = UserMiniProgramUse::query()->where('program_id', $programId)
                                              ->where('user_id',$this->userId())
                                              ->where('type',$type)
                                              ->first();
        if (!$useRecord instanceof UserMiniProgramUse) {
            $useRecord = new UserMiniProgramUse();
            $useRecord->program_id = $programId;
            $useRecord->user_id = $this->userId();
            $useRecord->count = 1;
            $useRecord->saveOrFail();
            return $this->success();
        }
        $useRecord->increment('count');
        return  $this->success();
    }

    public function markOfficialAccountUse(int $accountId)
    {
        $useRecord = UserOfficialAccountUse::query()->where('account_id', $accountId)
            ->where('user_id',$this->userId())
            ->first();
        if (!$useRecord instanceof UserOfficialAccountUse) {
            $useRecord = new UserOfficialAccountUse();
            $useRecord->account_id = $accountId;
            $useRecord->user_id = $this->userId();
            $useRecord->count = 1;
            $useRecord->saveOrFail();
            return $this->success();
        }
        $useRecord->increment('count');
        return  $this->success();
    }

    public function getUserMiniProgramAlwaysUseList(int $pageIndex, int $pageSize, string $type = null)
    {
        if(!isset($type)) {
            $type = 'weixin';
        }
        $list = UserMiniProgramUse::query()->where('user_id',$this->userId())
                                          ->where('count','>=', self::MINI_PROGRAM_BASE_ALWAYS_USE_COUNT)
                                          ->where('type',$type)
                                          ->offset($pageIndex * $pageSize)
                                          ->orderByDesc('is_outside')
                                          ->limit($pageSize)
                                          ->get();
        $total = UserMiniProgramUse::query()->where('user_id',$this->userId())
            ->where('count','>=', self::MINI_PROGRAM_BASE_ALWAYS_USE_COUNT)
            ->count();

        return ['total'=>$total,'list'=>$list];
    }

    public function getUserMiniProgramUseList(int $pageIndex, int $pageSize, string $type = 'weixin')
    {
        $list = UserMiniProgramUse::query()->where('user_id',$this->userId())
            ->where('type',$type)
            ->offset($pageIndex * $pageSize)
            ->orderByDesc('is_outside')
            ->limit($pageSize)
            ->get();
        $total = UserMiniProgramUse::query()->where('user_id',$this->userId())
            ->count();

        return ['total'=>$total,'list'=>$list];
    }

    public function markMiniProgramOutside(int $programId, string $type = 'weixin')
    {
        //是不是超过了三个
        $total = UserMiniProgramUse::query()->where('user_id', $this->userId())
            ->where('type',$type)
            ->where('is_outside', Constants::STATUS_DONE)
            ->count();
        if ($total >= self::MINI_PROGRAM_BASE_ALWAYS_USE_COUNT) {
            throw new HyperfCommonException(\App\Constants\ErrorCode::OUTSIDE_MINI_PROGRAM_FULL);
        }
       $record = UserMiniProgramUse::query()->where('user_id', $this->userId())
                                            ->where('program_id', $programId)
                                            ->first();
       if (!$record instanceof UserMiniProgramUse) {
           $record = new UserMiniProgramUse();
           $record->program_id = $programId;
           $record->user_id = $this->userId();
           $record->count = 1;
       }
       $record->is_outside = Constants::STATUS_DONE;
       $record->saveOrFail();
       return $this->success();
    }

    public function unbindMiniProgramOutside(int $programId, string $type = 'weixin')
    {
        $record = UserMiniProgramUse::query()->where('user_id', $this->userId())
            ->where('type',$type)
            ->where('program_id', $programId)
            ->first();
        if (!$record instanceof UserMiniProgramUse) {
            throw new HyperfCommonException(ErrorCode::RECORD_DID_EXIST);
        }
        $record->is_outside = Constants::STATUS_WAIT;
        $record->saveOrFail();
        return $this->success();
    }
}