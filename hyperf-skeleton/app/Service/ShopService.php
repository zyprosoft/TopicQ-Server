<?php


namespace App\Service;


use App\Constants\ErrorCode;
use App\Model\Order;
use App\Model\Shop;
use App\Model\ShopExtendCode;
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
            Log::info("保存七牛云路径:".$saveFilePath);
            $result = $filesystem->writeStream($saveFilePath, $stream);

            fclose($stream);

            if (!$result) {
                throw new HyperfCommonException(\ZYProSoft\Constants\ErrorCode::SYSTEM_ERROR_UPLOAD_MOVE_FILE_FAIL, "upload move file to qiniu fail!");
            }

            Log::info("上传七牛云结果:".json_encode($result));
            if ($filesystem instanceof QiniuAdapter) {
                $url =  $filesystem->getUrl($saveFilePath);
                $shop->qr_code = $url;
                $shop->saveOrFail();
                Log::info("店铺({$shopId})小程序二维码保存成功");
            }else{
                Log::info("店铺({$shopId})小程序二维码保存到七牛云失败!");
            }
        }else{
            //获取店铺小程序码失败
            Log::error("获取店铺($shopId)小程序码失败!");
            Log::error('错误详情:'.json_encode($response));
        }
    }

    public function generateTableQrCode(string $tableSn, int $shopId)
    {
        //创建店铺的指定位置的二维码
        $miniProgramConfig = config('weixin.miniProgram');
        Log::info('min program config:'.json_encode($miniProgramConfig));
        $app = Factory::miniProgram($miniProgramConfig);

        //获取图片 eg.tableSn=A13&inShop=1
        $scene = 'shopId='.$shopId.'&inShop=1&tableSn='.$tableSn;
        $response = $app->app_code->getUnlimit($scene, [
            'page'  => 'pages/detail/detail',
            'width' => 600,
        ]);
        // $response 成功时为 EasyWeChat\Kernel\Http\StreamResponse 实例，失败为数组或你指定的 API 返回类型

        // 保存小程序码到文件
        if ($response instanceof StreamResponse) {

            $subDir = '/shop/table/qrcode';
            $saveDir = config('file.storage.local.root').$subDir;
            $filename = Carbon::now()->timestamp.'';
            $filename = $response->save($saveDir,$filename);

            //获取七牛存储，上传到七牛
            $stream = fopen($saveDir.'/'.$filename, 'r+');
            $filesystem = ApplicationContext::getContainer()->get(FilesystemFactory::class)->get('qiniu');
            var_dump($filesystem);
            $saveFilePath = $subDir.'/'.$filename;
            Log::info("保存七牛云路径:".$saveFilePath);
            $result = $filesystem->writeStream($saveFilePath, $stream);

            fclose($stream);
            Log::info("保存文件到七牛云:".json_encode($result));
            if (!$result) {
                throw new HyperfCommonException(\ZYProSoft\Constants\ErrorCode::SYSTEM_ERROR_UPLOAD_MOVE_FILE_FAIL, "upload move file to qiniu fail!");
            }
            if ($filesystem instanceof QiniuAdapter) {
                $url =  $filesystem->getUrl($saveFilePath);
                Log::info("店铺({$shopId})桌号{$tableSn}二维码保存成功");
                return $url;
            }
            Log::info("非七牛云系统!");
        }else{
            //获取店铺小程序码失败
            Log::error("获取店铺($shopId)桌号小程序码失败!");
            Log::error('错误详情:'.json_encode($response));
            throw new HyperfCommonException(ErrorCode::SERVER_ERROR,'微信生成指定小程序码失败!');
        }
    }

    public function generateFinalTableCode(string $tableSn,string $qrCodeUrl)
    {

    }

    /**
     * 生成宣传海报
     * @param array 参数,包括图片和文字
     * @param string $filename 生成海报文件名,不传此参数则不生成文件,直接输出图片
     * @return [type] [description]
     */
    function imgTextMerge($config=array(),$filename=""){
        //如果要看报什么错，可以先注释调这个header
//        if(empty($filename)) header("content-type: image/png");
        $imageDefault = array(
            'left'=>0,
            'top'=>0,
            'right'=>0,
            'bottom'=>0,
            'width'=>0,
            'height'=>0,
            'opacity'=>100
        );
        $textDefault = array(
            'text'=>'',
            'left'=>0,
            'top'=>0,
            'fontSize'=>32, //字号
            'fontColor'=>'255,255,255', //字体颜色
            'angle'=>0,
        );
        $background = $config['background'];//海报最底层得背景
        //背景方法
        $backgroundInfo = getimagesize($background);
        $backgroundFun = 'imagecreatefrom'.image_type_to_extension($backgroundInfo[2], false);
        $background = $backgroundFun($background);
        $backgroundWidth = imagesx($background); //背景宽度
        $backgroundHeight = imagesy($background); //背景高度
        $imageRes = imageCreatetruecolor($backgroundWidth,$backgroundHeight);
        $color = imagecolorallocate($imageRes, 255, 255, 255);
        imagefill($imageRes, 0, 0, $color);
        // imageColorTransparent($imageRes, $color); //颜色透明
        imagecopyresampled($imageRes,$background,0,0,0,0,imagesx($background),imagesy($background),imagesx($background),imagesy($background));
        //处理了图片
        if(!empty($config['image'])){
            foreach ($config['image'] as $key => $val) {
                $val = array_merge($imageDefault,$val);
                $info = getimagesize($val['url']);
                $function = 'imagecreatefrom'.image_type_to_extension($info[2], false);
                $res = $function($val['url']);
                $resWidth = $info[0];
                $resHeight = $info[1];
                //建立画板 ，缩放图片至指定尺寸
                $canvas=imagecreatetruecolor($val['width'], $val['height']);
                imagefill($canvas, 0, 0, $color);
                //关键函数，参数（目标资源，源，目标资源的开始坐标x,y, 源资源的开始坐标x,y,目标资源的宽高w,h,源资源的宽高w,h）
                imagecopyresampled($canvas, $res, 0, 0, 0, 0, $val['width'], $val['height'],$resWidth,$resHeight);
                $val['left'] = $val['left']<0?$backgroundWidth- abs($val['left']) - $val['width']:$val['left'];
                $val['top'] = $val['top']<0?$backgroundHeight- abs($val['top']) - $val['height']:$val['top'];
                //放置图像
                imagecopymerge($imageRes,$canvas, $val['left'],$val['top'],$val['right'],$val['bottom'],$val['width'],$val['height'],$val['opacity']);//左，上，右，下，宽度，高度，透明度
            }
        }
        //处理文字
        if(!empty($config['text'])){
            foreach ($config['text'] as $key => $val) {
                $val = array_merge($textDefault,$val);
                list($R,$G,$B) = explode(',', $val['fontColor']);
                $fontColor = imagecolorallocate($imageRes, $R, $G, $B);
                $val['left'] = $val['left']<0?$backgroundWidth- abs($val['left']):$val['left'];
                $val['top'] = $val['top']<0?$backgroundHeight- abs($val['top']):$val['top'];

                $text = $val['text'];
                $fontSize = $val['fontSize'];
                $angle = $val['angle'];
                $fontPath = $val['fontPath'];
                $width = $val['width'];
                $outStyle = $val['outStyle'];
                $suffix = isset($val['suffix'])?$val['suffix']:'';
                $text = $this->textWidth($fontSize,$angle,$fontPath,$text,$width,$outStyle,$suffix);

                imagettftext($imageRes,$val['fontSize'],$val['angle'],$val['left'],$val['top'],$fontColor,$val['fontPath'],$text);
            }
        }
        //生成图片
        if(!empty($filename)){
            $res = imagejpeg($imageRes,$filename,100); //保存到本地
            imagedestroy($imageRes);
            if(!$res) return false;
            return $filename;
        }else{
            imagejpeg($imageRes); //在浏览器上显示
            imagedestroy($imageRes);
        }
    }
    /**
     * 文字超出宽度
     * @param $fontsize //字体大小
     * @param $angle //角度
     * @param $fontface //字体名称
     * @param $string //字符串
     * @param $width //预设宽度
     * @param $outStyle //超出宽度操作类型（wrap：换行 hidden：隐藏 replace：替换）
     * @param $suffix //outStyle值为replace时，替换的内容
     * @return string
     */
    function textWidth($fontsize, $angle, $fontface, $string, $width, $outStyle = 'replace', $suffix = '...') {
        $content = "";

        // 将字符串拆分成一个个单字 保存到数组 letter 中
        for ($i=0;$i<mb_strlen($string);$i++) {
            $letter[] = mb_substr($string, $i, 1);
        }

        foreach ($letter as $l) {
            $teststr = $content.$l;
            $testbox = imagettfbbox($fontsize, $angle, $fontface, $teststr);
            // 判断拼接后的字符串是否超过预设的宽度
            $is_width = false;//是否超出宽度
            if (($testbox[2] > $width) && ($content !== "") && $width != 0) {
                $is_width = true;
            }
            if ($outStyle == 'wrap'){//超出换行
                if ($is_width) $content .= "\n";
            }elseif ($outStyle == 'hidden'){//超出隐藏
                if ($is_width) break;
            }elseif ($outStyle == 'replace'){//超出替换内容
                if ($is_width){$content .= $suffix; break;}
            }
            $content .= $l;
        }
        return $content;
    }

    public function test(string $mpUrl){
        $config = array(
            'text'=>array(
                array(
                    'text'=>'A12',
                    'left'=>50,
                    'top'=>700,
                    'fontPath'=>'/www/wwwroot/wryh.ttf', //字体文件
                    'fontSize'=>64, //字号
                    'fontColor'=>'0,206,100', //字体颜色
                    'angle'=>0,
                    'width'=>300,//文字超出宽度换行或隐藏，0不限制
                    'outStyle'=>'wrap',//超出宽度操作类型（wrap：换行 hidden：隐藏 replace：替换）
                ),
            ),
            'image'=>array(
                array(
                    'url'=>$mpUrl,
                    'left'=>530,
                    'top'=>870,
                    'right'=>0,
                    'bottom'=>0,
                    'width'=>220,
                    'height'=>220,
                    'stream'=>0, //图片资源是否是字符串图像流
                    'opacity'=>100 //不透明度
                ),
            ),
            'background'=>'https://www.icodefuture.com/pay_background.png',
        );

        $filename = '/uploads/'.time().'.jpg';
        $this->imgTextMerge($config,$filename);
    }
}