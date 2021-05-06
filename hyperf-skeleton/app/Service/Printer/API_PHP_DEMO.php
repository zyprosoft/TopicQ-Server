<?php
  header("Content-type: text/html; charset=utf-8");
  include 'HttpClient.class.php';

  define('USER', 'xxxxxxxxxxxxxxxxx');  //*必填*：飞鹅云后台注册账号
  define('UKEY', 'xxxxxxxxxxxxxxxxx');  //*必填*: 飞鹅云后台注册账号后生成的UKEY 【备注：这不是填打印机的KEY】
  define('SN', 'xxxxxxxxxxxxxxxxx');      //*必填*：打印机编号，必须要在管理后台里添加打印机或调用API接口添加之后，才能调用API

  //以下参数不需要修改
  define('IP','api.feieyun.cn');      //接口IP或域名
  define('PORT',80);            //接口IP端口
  define('PATH','/Api/Open/');    //接口路径


  //*************************************方法1 批量添加打印机接口*************************************************
  //***接口返回值说明***
  //正确例子：{"msg":"ok","ret":0,"data":{"ok":["sn#key#remark#carnum","316500011#abcdefgh#快餐前台"],"no":["316500012#abcdefgh#快餐前台#13688889999  （错误：识别码不正确）"]},"serverExecutedTime":3}
  //错误：{"msg":"参数错误 : 该帐号未注册.","ret":-2,"data":null,"serverExecutedTime":37}

  //提示：
  //$printerConten => 打印机编号sn(必填) # 打印机识别码key(必填) # 备注名称(选填) # 流量卡号码(选填)，多台打印机请换行（\n）添加新打印机信息，每次最多100台。
  //打开注释可测试
  //$printerContent = "sn1#key1#remark1#carnum1\nsn2#key2#remark2#carnum2";
  //printerAddlist($printerContent);



  //****************************************方法2 小票机打印订单接口****************************************************
  //***接口返回值说明***
  //正确例子：{"msg":"ok","ret":0,"data":"123456789_20160823165104_1853029628","serverExecutedTime":6}
  //错误例子：{"msg":"错误信息.","ret":非零错误码,"data":null,"serverExecutedTime":5}

  //标签说明：
  //单标签:
    //"<BR>"为换行,"<CUT>"为切刀指令(主动切纸,仅限切刀打印机使用才有效果)
    //"<LOGO>"为打印LOGO指令(前提是预先在机器内置LOGO图片),"<PLUGIN>"为钱箱或者外置音响指令
  //成对标签：
    //"<CB></CB>"为居中放大一倍,"<B></B>"为放大一倍,"<C></C>"为居中,<L></L>字体变高一倍
    //<W></W>字体变宽一倍,"<QR></QR>"为二维码,"<BOLD></BOLD>"为字体加粗,"<RIGHT></RIGHT>"为右对齐

    //拼凑订单内容时可参考如下格式
  //根据打印纸张的宽度，自行调整内容的格式，可参考下面的样例格式
  $content = '<CB>测试打印</CB><BR>';
  $content .= '名称　　　　　 单价  数量 金额<BR>';
  $content .= '--------------------------------<BR>';
  $content .= '饭　　　　　 　10.0   10  100.0<BR>';
  $content .= '炒饭　　　　　 10.0   10  100.0<BR>';
  $content .= '蛋炒饭　　　　 10.0   10  100.0<BR>';
  $content .= '鸡蛋炒饭　　　 10.0   10  100.0<BR>';
  $content .= '西红柿炒饭　　 10.0   10  100.0<BR>';
  $content .= '西红柿蛋炒饭　 10.0   10  100.0<BR>';
  $content .= '西红柿鸡蛋炒饭 10.0   10  100.0<BR>';
  $content .= '--------------------------------<BR>';
  $content .= '备注：加辣<BR>';
  $content .= '合计：xx.0元<BR>';
  $content .= '送货地点：广州市南沙区xx路xx号<BR>';
  $content .= '联系电话：13888888888888<BR>';
  $content .= '订餐时间：2014-08-08 08:08:08<BR>';
  $content .= '<QR>http://www.feieyun.com</QR>';//把二维码字符串用标签套上即可自动生成二维码


  //提示：
  //SN => 打印机编号
  //$content => 打印内容,不能超过5000字节
  //$times => 打印次数，默认为1。
  //打开注释可测试
  // printMsg(SN,$content,1);//该接口只能是小票机使用,如购买的是标签机请使用下面方法3，调用打印


  //****************************************方法3 标签机专用打印订单接口****************************************************
  //***接口返回值说明***
  //正确例子：{"msg":"ok","ret":0,"data":"123456789_20160823165104_1853029628","serverExecutedTime":6}
  //错误例子：{"msg":"错误信息.","ret":非零错误码,"data":null,"serverExecutedTime":5}

  //标签说明：
  $content = "<DIRECTION>1</DIRECTION>";//设定打印时出纸和打印字体的方向，n 0 或 1，每次设备重启后都会初始化为 0 值设置，1：正向出纸，0：反向出纸，
  $content .= "<TEXT x='9' y='10' font='12' w='1' h='2' r='0'>#001       五号桌      1/3</TEXT><TEXT x='80' y='80' font='12' w='2' h='2' r='0'>可乐鸡翅</TEXT><TEXT x='9' y='180' font='12' w='1' h='1' r='0'>张三先生       13800138000</TEXT>";//40mm宽度标签纸打印例子，打开注释调用标签打印接口打印
  
  //提示：
  //SN => 打印机编号
  //$content => 打印内容,不能超过5000字节
  //$times => 打印次数，默认为1。
  //打开注释可测试
  // printLabelMsg(SN,$content,1);//打开注释调用标签机打印接口进行打印,该接口只能是标签机使用，其它型号打印机请勿使用该接口


  //**************************************方法4 批量删除打印机**************************************************
  //***接口返回值说明***
  //成功：{"msg":"ok","ret":0,"data":{"ok":["123456789成功"],"no":[]},"serverExecutedTime":5}
  //错误：{"msg":"ok","ret":0,"data":{"ok":[],"no":["12345678打印机不存在"]},"serverExecutedTime":2}
  //错误：{"msg":"ok","ret":0,"data":{"ok":[],"no":["123456789用户UID不匹配"]},"serverExecutedTime":3}
  //提示：
  //$snlist => 打印机编号，多台打印机请用减号"-"连接起来。
  //打开注释可测试
  // $snlist = "123456789";
  // printerDelList($snlist);



  //************************************方法5 修改打印机信息接口************************************************
  //***接口返回值说明***
  //成功：{"msg":"ok","ret":0,"data":true,"serverExecutedTime":5}
  //错误：{"msg":"参数错误 : 参数值不能传空字符，\"\"、\"null\"、\"undefined\".","ret":-2,"data":null,"serverExecutedTime":1}
  //提示：
  //SN => 打印机编号
  //$name => 打印机备注名称
  //$phonenum => 打印机流量卡号码
  //打开注释可测试
  //$name = "飞鹅云打印机";
  //$phonenum = "01234567891011121314";
  // printerEdit(SN,$name,$phonenum);



  //************************************方法6 清空待打印订单接口************************************************
  //***接口返回值说明***
  //成功：{"msg":"ok","ret":0,"data":true,"serverExecutedTime":4}
  //错误：{"msg":"验证失败 : 打印机编号和用户不匹配.","ret":1002,"data":null,"serverExecutedTime":3}
  //错误：{"msg":"参数错误 : 参数值不能传空字符，\"\"、\"null\"、\"undefined\".","ret":-2,"data":null,"serverExecutedTime":2}
  //提示：
  //SN => 打印机编号
  //打开注释可测试
  // delPrinterSqs(SN);


  //*********************************方法7 查询订单是否打印成功接口*********************************************
  //***接口返回值说明***
  //正确例子：
  //已打印：{"msg":"ok","ret":0,"data":true,"serverExecutedTime":6}
  //未打印：{"msg":"ok","ret":0,"data":false,"serverExecutedTime":6}

  //提示：
  //$orderid => 订单ID，由方法1接口Open_printMsg返回。
  //打开注释可测试
  //$orderid = "123456789_20160823165104_1853029628";//订单ID，从方法1返回值中获取
  //queryOrderState($orderid);



  //*****************************方法8 查询指定打印机某天的订单统计数接口*****************************************
  //***接口返回值说明***
  //正确例子：
  //{"msg":"ok","ret":0,"data":{"print":6,"waiting":1},"serverExecutedTime":9}
  //错误：{"msg":"验证失败 : 打印机编号和用户不匹配.","ret":1002,"data":null,"serverExecutedTime":3}

  //提示：
  //$date => 查询日期，格式YY-MM-DD，如：2016-09-20
  //打开注释可测试
  // $date = "2016-09-20";
  // queryOrderInfoByDate(SN,$date);



  //***********************************方法9 获取某台打印机状态接口***********************************************
  //***接口返回值说明***
  //正确例子：
  //{"msg":"ok","ret":0,"data":"离线","serverExecutedTime":9}
  //{"msg":"ok","ret":0,"data":"在线，工作状态正常","serverExecutedTime":9}
  //{"msg":"ok","ret":0,"data":"在线，工作状态不正常","serverExecutedTime":9}

  //提示：
  //SN => 填打印机编号
  //打开注释可测试
  // queryPrinterStatus(SN);




  /**
   * [批量添加打印机接口 Open_printerAddlist]
   * @param  [string] $printerContent [打印机的sn#key]
   * @return [string]                 [接口返回值]
   */
  function printerAddlist($printerContent){
    $time = time();         //请求时间
    $msgInfo = array(
      'user'=>USER,
      'stime'=>$time,
      'sig'=>signature($time),
      'apiname'=>'Open_printerAddlist',
      'printerContent'=>$printerContent
    );
    $client = new HttpClient(IP,PORT);
    if(!$client->post(PATH,$msgInfo)){
      echo 'error';
    }else{
      $result = $client->getContent();
      echo $result;
    }
  }


  /**
   * [打印订单接口 Open_printMsg]
   * @param  [string] $sn      [打印机编号sn]
   * @param  [string] $content [打印内容]
   * @param  [string] $times   [打印联数]
   * @return [string]          [接口返回值]
   */
  function printMsg($sn,$content,$times){
    $time = time();         //请求时间
    $msgInfo = array(
      'user'=>USER,
      'stime'=>$time,
      'sig'=>signature($time),
      'apiname'=>'Open_printMsg',
      'sn'=>$sn,
      'content'=>$content,
      'times'=>$times//打印次数
    );
    $client = new HttpClient(IP,PORT);
    if(!$client->post(PATH,$msgInfo)){
      echo 'error';
    }else{
      //服务器返回的JSON字符串，建议要当做日志记录起来
      $result = $client->getContent();
      echo $result;
    }
  }

  /**
   * [标签机打印订单接口 Open_printLabelMsg]
   * @param  [string] $sn      [打印机编号sn]
   * @param  [string] $content [打印内容]
   * @param  [string] $times   [打印联数]
   * @return [string]          [接口返回值]
   */
  function printLabelMsg($sn,$content,$times){
    $time = time();         //请求时间
    $msgInfo = array(
      'user'=>USER,
      'stime'=>$time,
      'sig'=>signature($time),
      'apiname'=>'Open_printLabelMsg',
      'sn'=>$sn,
      'content'=>$content,
      'times'=>$times//打印次数
    );
    $client = new HttpClient(IP,PORT);
    if(!$client->post(PATH,$msgInfo)){
      echo 'error';
    }else{
      //服务器返回的JSON字符串，建议要当做日志记录起来
      $result = $client->getContent();
      echo $result;
    }
  }

  /**
   * [批量删除打印机 Open_printerDelList]
   * @param  [string] $snlist [打印机编号，多台打印机请用减号“-”连接起来]
   * @return [string]         [接口返回值]
   */
  function printerDelList($snlist){
    $time = time();         //请求时间
    $msgInfo = array(
      'user'=>USER,
      'stime'=>$time,
      'sig'=>signature($time),
      'apiname'=>'Open_printerDelList',
      'snlist'=>$snlist
    );
    $client = new HttpClient(IP,PORT);
    if(!$client->post(PATH,$msgInfo)){
      echo 'error';
    }else{
      $result = $client->getContent();
      echo $result;
    }
  }

  /**
   * [修改打印机信息接口 Open_printerEdit]
   * @param  [string] $sn       [打印机编号]
   * @param  [string] $name     [打印机备注名称]
   * @param  [string] $phonenum [打印机流量卡号码,可以不传参,但是不能为空字符串]
   * @return [string]           [接口返回值]
   */
  function printerEdit($sn,$name,$phonenum){
    $time = time();         //请求时间
    $msgInfo = array(
      'user'=>USER,
      'stime'=>$time,
      'sig'=>signature($time),
      'apiname'=>'Open_printerEdit',
      'sn'=>$sn,
      'name'=>$name,
      'phonenum'=>$phonenum
    );
    $client = new HttpClient(IP,PORT);
    if(!$client->post(PATH,$msgInfo)){
      echo 'error';
    }else{
      $result = $client->getContent();
      echo $result;
    }
  }


  /**
   * [清空待打印订单接口 Open_delPrinterSqs]
   * @param  [string] $sn [打印机编号]
   * @return [string]     [接口返回值]
   */
  function delPrinterSqs($sn){
    $time = time();         //请求时间
    $msgInfo = array(
      'user'=>USER,
      'stime'=>$time,
      'sig'=>signature($time),
      'apiname'=>'Open_delPrinterSqs',
      'sn'=>$sn
    );
    $client = new HttpClient(IP,PORT);
    if(!$client->post(PATH,$msgInfo)){
      echo 'error';
    }else{
      $result = $client->getContent();
      echo $result;
    }
  }

  /**
   * [查询订单是否打印成功接口 Open_queryOrderState]
   * @param  [string] $orderid [调用打印机接口成功后,服务器返回的JSON中的编号 例如：123456789_20190919163739_95385649]
   * @return [string]          [接口返回值]
   */
  function queryOrderState($orderid){
    $time = time();         //请求时间
    $msgInfo = array(
      'user'=>USER,
      'stime'=>$time,
      'sig'=>signature($time),
      'apiname'=>'Open_queryOrderState',
      'orderid'=>$orderid
    );
    $client = new HttpClient(IP,PORT);
    if(!$client->post(PATH,$msgInfo)){
      echo 'error';
    }else{
      $result = $client->getContent();
      echo $result;
    }
  }

  /**
   * [查询指定打印机某天的订单统计数接口 Open_queryOrderInfoByDate]
   * @param  [string] $sn   [打印机的编号]
   * @param  [string] $date [查询日期，格式YY-MM-DD，如：2019-09-20]
   * @return [string]       [接口返回值]
   */
  function queryOrderInfoByDate($sn,$date){
    $time = time();         //请求时间
    $msgInfo = array(
      'user'=>USER,
      'stime'=>$time,
      'sig'=>signature($time),
      'apiname'=>'Open_queryOrderInfoByDate',
      'sn'=>$sn,
      'date'=>$date
    );
    $client = new HttpClient(IP,PORT);
    if(!$client->post(PATH,$msgInfo)){
      echo 'error';
    }else{
      $result = $client->getContent();
      echo $result;
    }
  }

  /**
   * [获取某台打印机状态接口 Open_queryPrinterStatus]
   * @param  [string] $sn [打印机编号]
   * @return [string]     [接口返回值]
   */
  function queryPrinterStatus($sn){
    $time = time();         //请求时间
    $msgInfo = array(
      'user'=>USER,
      'stime'=>$time,
      'sig'=>signature($time),
      'apiname'=>'Open_queryPrinterStatus',
      'sn'=>$sn
    );
    $client = new HttpClient(IP,PORT);
    if(!$client->post(PATH,$msgInfo)){
      echo 'error';
    }else{
      $result = $client->getContent();
      echo $result;
    }
  }

  /**
   * [signature 生成签名]
   * @param  [string] $time [当前UNIX时间戳，10位，精确到秒]
   * @return [string]       [接口返回值]
   */
  function signature($time){
    return sha1(USER.UKEY.$time);//公共参数，请求公钥
  }

?>
