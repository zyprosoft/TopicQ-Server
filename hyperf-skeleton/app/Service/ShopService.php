<?php


namespace App\Service;


use App\Model\Order;
use App\Model\Shop;
use Carbon\Carbon;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Http\StreamResponse;
use Hyperf\Filesystem\FilesystemFactory;
use Hyperf\Utils\ApplicationContext;
use Overtrue\Flysystem\Qiniu\QiniuAdapter;
use ZYProSoft\Exception\HyperfCommonException;
use ZYProSoft\Log\Log;

class ShopService extends BaseService
{
    public function info(int $shopId)
    {
        $shop = Shop::query()->where('shop_id', $shopId)
            ->with(['owner'])
            ->firstOrFail();
        if (!$shop instanceof Shop) {
            Log::info('find shop fail!');
        }

        //获取店铺最晚的订单的信息返回
        if(!empty($shop->latest_order_list)) {
            $orderIds = explode(';', $shop->latest_order_list);
            if (!empty($orderIds)) {
                $orderList = Order::query()->whereIn('order_id', $orderIds)
                    ->with(['owner','order_goods'])
                    ->latest()
                    ->get();
                $shop->latest_order_list = $orderList;
            }
        }

        //转化成数组返回
        if (!empty($shop->avatar_list)) {
            $shop->avatar_list = explode(';',$shop->avatar_list);
        }

        return $shop;
    }

    public function getQrCode(int $shopId)
    {
        //创建店铺的小程序码图片
        $shop = Shop::findOrFail($shopId);
        if(!empty($shop->qr_code)) {
            Log::info("shop($shopId) has qr_code exist!");
            return;
        }
        $miniProgramConfig = config('weixin.miniProgram');
        Log::info('min program config:'.json_encode($miniProgramConfig));
        $app = Factory::miniProgram($miniProgramConfig);

        //获取图片
        $response = $app->app_code->getUnlimit('postId='.$shopId, [
            'page'  => 'pages/detail/detail',
            'width' => 600,
        ]);
        // $response 成功时为 EasyWeChat\Kernel\Http\StreamResponse 实例，失败为数组或你指定的 API 返回类型

        // 保存小程序码到文件
        if ($response instanceof StreamResponse) {

            Log::info("小程序码微信获取结果:".$response->toJson());

            $subDir = '/shop/qrcode';
            $saveDir = config('file.storage.local.root').$subDir;
            $filename = Carbon::now()->timestamp.'';
            $filename = $response->save($saveDir,$filename);

            //获取七牛存储，上传到七牛
            $stream = fopen($saveDir.'/'.$filename, 'r+');
            $filesystem = ApplicationContext::getContainer()->get(FilesystemFactory::class)->get('qiniu');
            $saveFilePath = $subDir.'/'.$filename;
            $result = $filesystem->writeStream($saveFilePath, $stream);

            fclose($stream);

            if (!$result) {
                throw new HyperfCommonException(\ZYProSoft\Constants\ErrorCode::SYSTEM_ERROR_UPLOAD_MOVE_FILE_FAIL, "upload move file to qiniu fail!");
            }
            if ($filesystem instanceof QiniuAdapter) {
                $url =  $filesystem->getUrl($saveFilePath);
                $shop->qr_code = $url;
                $shop->saveOrFail();
                Log::info("店铺({$shopId})小程序二维码保存成功");
            }
        }else{
            //获取店铺小程序码失败
            Log::error("获取店铺($shopId)小程序码失败!");
            Log::error('错误详情:'.json_encode($response));
        }
    }
}