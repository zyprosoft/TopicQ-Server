<?php


namespace App\Service;


use App\Constants\Constants;
use App\Model\MiniProgram;
use App\Model\MiniProgramCategory;
use App\Model\OfficialAccount;
use App\Model\OfficialAccountCategory;
use App\Model\UserThirdPartUse;

class ThirdPartService extends BaseService
{
    const MINI_PROGRAM_BASE_ALWAYS_USE_COUNT = 3;

    public function getAllMiniProgram(bool $byCategory = false)
    {
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

    public function markThirdPartUsed(string $partId,int $type)
    {
        $useRecord = UserThirdPartUse::query()->where('third_part_id', $partId)
                                              ->where('third_part_type', $type)
                                              ->where('user_id',$this->userId())
                                              ->first();
        if (!$useRecord instanceof UserThirdPartUse) {
            $useRecord = new UserThirdPartUse();
            $useRecord->third_part_id = $partId;
            $useRecord->third_part_type = $type;
            $useRecord->user_id = $this->userId();
            $useRecord->count = 1;
            $useRecord->saveOrFail();
            return $this->success();
        }
        $useRecord->increment('count');
        return  $this->success();
    }

    public function getUserThirdPartAlwaysUseList()
    {
        

    }
}