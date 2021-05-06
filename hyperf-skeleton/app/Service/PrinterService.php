<?php


namespace App\Service;
use App\Constants\Constants;
use App\Constants\ErrorCode;
use App\Model\Order;
use App\Model\OrderGood;
use Carbon\Carbon;
use Psr\Container\ContainerInterface;
use ZYProSoft\Exception\HyperfCommonException;
use ZYProSoft\Log\Log;
use ZYProSoft\Service\AbstractService;
use App\Service\Printer\HttpClient;

class PrinterService extends AbstractService
{
    protected string $configUser;

    protected string $configKey;

    const IP = 'api.feieyun.cn';
    const PORT = 80;
    const PATH = '/Api/Open/';

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->configUser = config('printer.user');
        $this->configKey = config('printer.key');
    }

    /**
     * 打印订单相关信息
     * @param string $orderNo
     */
    public function printerOrder(string $orderNo)
    {
        $order = Order::query()->where('order_no',$orderNo)->with(['shop','order_goods','owner'])->first();
        if (!$order instanceof Order) {
            Log::error("打印服务未发现订单({$orderNo})");
            return;
        }
        //拼凑订单内容时可参考如下格式
        //根据打印纸张的宽度，自行调整内容的格式，可参考下面的样例格式
        $content = '<CB>订单详情</CB><BR>';
        $content .= "订单号:$orderNo<BR>";
        $content .= '名称　　数量 <BR>';
        $content .= '--------------------------------<BR>';
        $order->order_goods->map(function (OrderGood $orderGood) use (&$content) {
           $item = $orderGood->order_goods_name.'    '.$orderGood->count.' '.$orderGood->order_unit.'<BR>';
           $content .= $item;
        });
        $content .= '--------------------------------<BR>';
        if(!empty($order->customer_note)) {
            $content .= "备注：{$order->customer_note}<BR>";
        }
        $cashLabel = $order->cash/100;
        $content .= "合计：{$cashLabel}元<BR>";
        $content .= "收货地址：{$order->address}<BR>";
        $deliverLabel = $order->deliver_type == Constants::DELIVER_TYPE_SELF_GET? '自取':'送货';
        $content .= "配送方式：{$deliverLabel}<BR>";
        $content .= "联系人：{$order->nickname}<BR>";
        $content .= "联系电话：{$order->mobile}<BR>";
        $content .= "订餐时间：{$order->pay_time}<BR>";
        $content .= '--------------------------------<BR>';
        $content .= "店铺:{$order->shop->name}<BR>";
        $content .= "地址:{$order->shop->address}";
        $printOrderId = $this->printMsg($order->shop->printer_sn,$content,'1');
        Log::info("{$orderNo} 已经打印完成:".$printOrderId);
        //保存打印结果
        $order->print_order_id = $printOrderId;
        $order->print_time = Carbon::now()->toDateTimeString();
        $order->saveOrFail();
        Log::info("成功打印订单{$orderNo}");
    }

    /**
     * [signature 生成签名]
     * @param  [string] $time [当前UNIX时间戳，10位，精确到秒]
     * @return [string]       [接口返回值]
     */
    protected function signature($time){
        return sha1($this->configUser.$this->configKey.$time);//公共参数，请求公钥
    }

    protected function request(array $params)
    {
        $time = time();         //请求时间
        $msgInfo = array(
            'user'=>$this->configUser,
            'stime'=>$time,
            'sig'=>$this->signature($time),
        );
        $msgInfo = collect($msgInfo)->union($params);
        Log::info("printer request msgInfo:".json_encode($msgInfo));
        $client = new HttpClient(self::IP,self::PORT);
        if(!$client->post(self::PATH,$msgInfo->toArray())){
            Log::error("printer request fail:".json_encode($msgInfo));
            throw new HyperfCommonException(ErrorCode::PRINTER_REQUEST_FAIL);
        }else{
            $result = $client->getContent();
            Log::info("云打印返回结果:".$result);
            $result = json_decode($result);
            $statusCode = data_get($result,'ret');
            Log::info("云打印结果状态码:".$statusCode);
            if($statusCode != 0) {
                throw new HyperfCommonException(ErrorCode::PRINTER_REQUEST_FAIL,data_get($result,'msg'));
            }
            $data = data_get($result,'data');
            Log::info("云打印请求成功:".$data);
            return $data;
        }
    }

    /**
     * [批量添加打印机接口 Open_printerAddlist]
     * @param  [string] $printerContent [打印机的sn#key]
     * @return [string]                 [接口返回值]
     */
    public function printerAddlist(string $printerContent){
        $param = [
            'apiname'=>'Open_printerAddlist',
            'printerContent'=>$printerContent
        ];
        $this->request($param);
    }

    /**
     * [打印订单接口 Open_printMsg]
     * @param  [string] $sn      [打印机编号sn]
     * @param  [string] $content [打印内容]
     * @param  [string] $times   [打印联数]
     * @return [string]          [接口返回值]
     */
    public function printMsg(string $sn,string $content,string $times){
        return $this->request([
            'apiname'=>'Open_printMsg',
            'sn'=>$sn,
            'content'=>$content,
            'times'=>$times//打印次数
        ]);
    }

    /**
     * [标签机打印订单接口 Open_printLabelMsg]
     * @param  [string] $sn      [打印机编号sn]
     * @param  [string] $content [打印内容]
     * @param  [string] $times   [打印联数]
     * @return [string]          [接口返回值]
     */
    public function printLabelMsg(string $sn,string $content,string $times){
        return $this->request([
            'apiname'=>'Open_printLabelMsg',
            'sn'=>$sn,
            'content'=>$content,
            'times'=>$times//打印次数
        ]);
    }

    /**
     * [批量删除打印机 Open_printerDelList]
     * @param  array $snlist [打印机编号，多台打印机请用减号“-”连接起来]
     * @return string         [接口返回值]
     */
    public function printerDelList(array $snList){
        return $this->request([
            'apiname'=>'Open_printerDelList',
            'snlist'=>implode('-',$snList)
        ]);
    }

    /**
     * [修改打印机信息接口 Open_printerEdit]
     * @param  [string] $sn       [打印机编号]
     * @param  [string] $name     [打印机备注名称]
     * @param  [string] $phonenum [打印机流量卡号码,可以不传参,但是不能为空字符串]
     * @return [string]           [接口返回值]
     */
    public function printerEdit(string $sn,string $name,string $phonenum){
        return $this->request([
            'apiname'=>'Open_printerEdit',
            'sn'=>$sn,
            'name'=>$name,
            'phonenum'=>$phonenum
        ]);
    }

    /**
     * [清空待打印订单接口 Open_delPrinterSqs]
     * @param  [string] $sn [打印机编号]
     * @return [string]     [接口返回值]
     */
    public function delPrinterSqs(string $sn){
        return $this->request([
            'apiname'=>'Open_delPrinterSqs',
            'sn'=>$sn
        ]);
    }

    /**
     * [查询订单是否打印成功接口 Open_queryOrderState]
     * @param  [string] $orderid [调用打印机接口成功后,服务器返回的JSON中的编号 例如：123456789_20190919163739_95385649]
     * @return [string]          [接口返回值]
     */
    public function queryOrderState(string $orderid){
        return $this->request([
            'apiname'=>'Open_queryOrderState',
            'orderid'=>$orderid
        ]);
    }

    /**
     * [查询指定打印机某天的订单统计数接口 Open_queryOrderInfoByDate]
     * @param  [string] $sn   [打印机的编号]
     * @param  [string] $date [查询日期，格式YY-MM-DD，如：2019-09-20]
     * @return [string]       [接口返回值]
     */
    public function queryOrderInfoByDate(string $sn,string $date){
        return $this->request([
            'apiname'=>'Open_queryOrderInfoByDate',
            'sn'=>$sn,
            'date'=>$date
        ]);
    }

    /**
     * [获取某台打印机状态接口 Open_queryPrinterStatus]
     * @param  [string] $sn [打印机编号]
     * @return [string]     [接口返回值]
     */
    public function queryPrinterStatus(string $sn){
        return $this->request([
            'apiname'=>'Open_queryPrinterStatus',
            'sn'=>$sn
        ]);
    }
}