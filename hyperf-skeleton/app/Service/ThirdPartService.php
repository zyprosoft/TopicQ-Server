<?php


namespace App\Service;


use App\Model\MiniProgram;
use App\Model\MiniProgramCategory;
use App\Model\OfficialAccount;
use App\Model\OfficialAccountCategory;
use ZYProSoft\Constants\ErrorCode;
use ZYProSoft\Exception\HyperfCommonException;

class ThirdPartService extends BaseService
{
    public function getAllMiniProgram(bool $byCategory = false)
    {
        $list = MiniProgram::all();
        if ($byCategory == false) {
            return $list;
        }
        $byCategoryList = [];
        $list->map(function (MiniProgram $miniProgram) use (&$byCategoryList) {
              if (!$byCategoryList[$miniProgram->category_id]) {
                  $byCategoryList[$miniProgram->category_id] = [];
              }
              $byCategoryList[$miniProgram->category_id][] = $miniProgram;
        });
        return $byCategoryList;
    }

    public function getAllOfficialAccount(bool $byCategory = false)
    {
        $list = OfficialAccount::all();
        if ($byCategory == false) {
            return $list;
        }
        $byCategoryList = [];
        $list->map(function (OfficialAccount $officialAccount) use (&$byCategoryList) {
            if (!$byCategoryList[$officialAccount->category_id]) {
                $byCategoryList[$officialAccount->category_id] = [];
            }
            $byCategoryList[$officialAccount->category_id][] = $officialAccount;
        });
        return $byCategoryList;
    }
}