<?php


namespace App\Service;


use App\Constants\Constants;
use App\Constants\ErrorCode;
use App\Model\Voucher;
use App\Model\VoucherPolicy;
use Carbon\Carbon;
use Hyperf\DbConnection\Db;
use ZYProSoft\Exception\HyperfCommonException;

class VoucherService extends BaseService
{
    protected function generateVoucherSn(string $prefix)
    {
        $datetime = date('YmdHis');
        $now = Carbon::now();
        $microsecond = $now->microsecond;
        return $prefix.$datetime.$microsecond;
    }

    /**
     * 用户领券
     * @param integer $policyId
     */
    public function createVoucher(int $policyId)
    {
        Db::transaction(function () use ($policyId) {

            //批次检查
            $policy = VoucherPolicy::findOrFail($policyId);

            //用户是不是领过这个批次的券，一个批次只能领一次
            $voucher = Voucher::query()->where('policy_id', $policyId)
                ->where('owner_id',$this->userId())
                ->first();
            if ($voucher instanceof Voucher) {
                throw new HyperfCommonException(ErrorCode::VOUCHER_CREATE_REPEAT);
            }
            $voucher = new Voucher();
            $voucher->policy_id = $policyId;
            $voucher->owner_id = $this->userId();
            $voucher->left_amount = $policy->amount;
            $voucher->voucher_sn = $this->generateVoucherSn($policy->sn_prefix);
            //计算生效和过期时间
            if (!empty($policy->time_span) && !empty($policy->time_unit)) {
                $voucher->begin_time = Carbon::now()->toDateString();
                switch ($policy->time_unit) {
                    case Constants::VOUCHER_TIME_UNIT_MINUTE:
                        $endTime = Carbon::now()->addRealMinutes($policy->time_span);
                        break;
                    case Constants::VOUCHER_TIME_UNIT_HOUR:
                        $endTime = Carbon::now()->addRealHours($policy->time_span);
                        break;
                    case Constants::VOUCHER_TIME_UNIT_DAY:
                        $endTime = Carbon::now()->addRealDays($policy->time_span);
                        break;
                    case Constants::VOUCHER_TIME_UNIT_MONTH:
                        $endTime = Carbon::now()->addRealMonths($policy->time_span);
                        break;
                    case Constants::VOUCHER_TIME_UNIT_YEAR:
                        $endTime = Carbon::now()->addRealYears($policy->time_span);
                        break;
                    default:
                        $endTime = Carbon::now()->addRealMinutes(1)->toDateString();
                        break;
                }
                $voucher->end_time = $endTime->toDateString();
            }
            $voucher->saveOrFail();
        });
        return $this->success();
    }

    public function getMyVoucherList(int $pageIndex, int $pageSize)
    {
        $list = Voucher::query()->where('owner_id',$this->userId())
                                ->offset($pageIndex * $pageSize)
                                ->limit($pageSize)
                                ->latest()
                                ->get();
        $total = Voucher::query()->where('owner_id',$this->userId())->count();

        return ['total'=>$total,'list'=>$list];
    }
}