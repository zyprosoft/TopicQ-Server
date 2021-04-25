<?php


namespace App\Service;


use App\Model\MiniProgram;
use App\Model\MiniProgramCategory;
use App\Model\OfficialAccount;
use App\Model\OfficialAccountCategory;

class ThirdPartService extends BaseService
{
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

    }
}