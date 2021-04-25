<?php


namespace App\Service\Admin;

use App\Service\BaseService;
use App\Model\MiniProgram;
use App\Model\MiniProgramCategory;
use App\Model\OfficialAccount;
use App\Model\OfficialAccountCategory;
use ZYProSoft\Constants\ErrorCode;
use ZYProSoft\Exception\HyperfCommonException;

class ThirdPartService extends BaseService
{
    public function createMiniProgramCategory(string $name)
    {
        $category = MiniProgramCategory::query()->where('name',$name);
        if ($category instanceof MiniProgramCategory) {
            throw new HyperfCommonException(ErrorCode::RECORD_DID_EXIST);
        }
        $category = new MiniProgramCategory();
        $category->name = $name;
        $category->saveOrFail();
        return $this->success();
    }

    public function createOfficialAccountCategory(string $name)
    {
        $category = OfficialAccountCategory::query()->where('name',$name);
        if ($category instanceof MiniProgramCategory) {
            throw new HyperfCommonException(ErrorCode::RECORD_DID_EXIST);
        }
        $category = new OfficialAccountCategory();
        $category->name = $name;
        $category->saveOrFail();
        return $this->success();
    }

    public function addMiniProgram(int $categoryId, string $appId,string $shortName, string $name, string $icon, string $introduce)
    {
        $miniProgram = MiniProgram::query()->where('appId',$appId)
            ->first();
        if ($miniProgram instanceof MiniProgram) {
            throw new HyperfCommonException(ErrorCode::RECORD_DID_EXIST);
        }
        $miniProgram = new MiniProgram();
        $miniProgram->short_name = $shortName;
        $miniProgram->name = $name;
        $miniProgram->app_id = $appId;
        $miniProgram->icon = $icon;
        $miniProgram->category_id = $categoryId;
        $miniProgram->introduce = $introduce;
        $miniProgram->saveOrFail();
        return $this->success();
    }

    public function addOfficialAccount(int $categoryId, string $wechatId, string $name, string $icon, string $introduce)
    {
        $officialAccount = OfficialAccount::query()->where('wechat_id',$wechatId)
            ->first();
        if ($officialAccount instanceof OfficialAccount) {
            throw new HyperfCommonException(ErrorCode::RECORD_DID_EXIST);
        }
        $officialAccount = new OfficialAccount();
        $officialAccount->name = $name;
        $officialAccount->wechat_id = $wechatId;
        $officialAccount->icon = $icon;
        $officialAccount->category_id = $categoryId;
        $officialAccount->introduce = $introduce;
        $officialAccount->saveOrFail();
        return $this->success();
    }
}