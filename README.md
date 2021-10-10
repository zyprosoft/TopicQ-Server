# TopicQ微社区后台开源工程

### 运行环境要求  

后台基于Hyperf框架最新版本2.1进行开发

1. PHP >= 7.4
2. Swoole PHP 扩展 >= 4.5，并关闭了 Short Name
3. OpenSSL PHP 扩展
4. JSON PHP 扩展
5. PDO PHP 扩展 （如需要使用到 MySQL 客户端）
6. Redis PHP 扩展 （如需要使用到 Redis 客户端）
7. Protobuf PHP 扩展 （如需要使用到 gRPC 服务端或客户端）

### 项目安装

1. 克隆或下载master分支
2. 本地有composer可直接执行composer install
3. 本地无composer进入hyperf-skeletion目录，执行php composer.phar install

### 项目配置 

```.env
//服务基本配置
APP_NAME=dev_jianghu
APP_ENV=dev
HTTP_SERVER_PORT=9111 //服务端口
PROMETHEUS_SCRAPE_PORT=9112 //监控数据端口

//需打通公众号是否关注的可配置下面公众号信息
WX_FA_APPID=
WX_FA_SECRET=
WX_FA_TOKEN=
WX_FA_AES_EY=

//百度小程序配置
BAIDU_CLIENT_ID=
BAIDU_SECRET=

//QQ小程序配置
QQ_APPID=
QQ_SECRET=

//ES配置，可链接本地服务
SCOUT_PREFIX=
ELASTICSEARCH_HOST=

//用户默认地址信息
REGISTER_AREA=
REGISTER_COUNTRY=

//多多客配置
PDD_CLIENT_ID=
PDD_CLIENT_SECRET=
PDD_AUTH_CODE=1

//飞鹅打印机配置
PRINTER_USER=
PRINTER_KEY=

//微信支付信息
WX_PAY_MCH_ID=商户号
WX_PAY_SECRET=密钥
WX_PAY_NOTIFY_URL=//回调地址

//微信小程序配置
WX_MINI_ENV=trial\release
WX_MINI_APPID=
WX_MINI_SECRET=

//鉴权
SIMPLE_JWT_SECRET=//
SIMPLE_JWT_TTL=//token 有效时间 单位 秒

//ZGW协议
ZGW_FORCE_AUTH=//请求包是否强制校验签名true\false
ZGW_SECRET_LIST=//签名密钥对  key&secret 例. devtopic&topic
ZGW_SIGN_TTL=//签名有效时间，单位秒

//允许跨域域名列表，多个分号分割
CORS_ORIGIN_LIST=


//七牛配置，用于存储和短信验证码发送
QINIU_CDN_DOMAIN=//cdn域名
QINIU_SMS_APP_NAME=TopicQ
QINIU_LOGIN_SMS_TEMP_ID=//验证码短信模版
QINIU_ACCESS_KEY=
QINIU_SECRET_KEY=
QINIU_BUCKET=

//数据库配置
DB_DRIVER=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci

//redis配置
REDIS_HOST=localhost
REDIS_AUTH=
REDIS_PORT=6379
REDIS_DB=7
```
### nginx配置
```
server {

	#SSL 访问端口号为 443
        listen 443 ssl; 
        #填写绑定证书的域名
        server_name example.com; 
        #证书文件名称
        ssl_certificate 1_example.com_bundle.crt; 
        #私钥文件名称
        ssl_certificate_key 2_example.com.key; 
        ssl_session_timeout 5m;
        #请按照以下协议配置
        ssl_protocols TLSv1 TLSv1.1 TLSv1.2; 
        #请按照以下套件配置，配置加密套件，写法遵循 openssl 标准。
        ssl_ciphers ECDHE-RSA-AES128-GCM-SHA256:HIGH:!aNULL:!MD5:!RC4:!DHE; 
        ssl_prefer_server_ciphers on;

	error_log    /www/server/nginx/logs/example.com-error_log;
        access_log   /www/server/nginx/logs/example.com-access_log;

        proxy_connect_timeout 30;
        proxy_send_timeout 600;
        proxy_read_timeout 600;
	
	location / {
        
	    index index.html index.htm;
	    root /data/develop/dev.jianghu.lulinggushi.com/jianghu-server/hyperf-skeleton/public;	
	    proxy_http_version 1.1;
            proxy_set_header Connection "keep-alive";
            proxy_set_header Host $host;
            proxy_set_header X-Real-IP $remote_addr;
            proxy_set_header REMOTE-HOST $remote_addr;
            proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
            proxy_pass   http://127.0.0.1:9111;
        }

	location /wxpay/notify {

            index index.html index.htm;
            root /data/release/weshop.lulinggushi.com/public;
            proxy_http_version 1.1;
            proxy_set_header Connection "keep-alive";
            proxy_set_header Host $host;
            proxy_set_header X-Real-IP $remote_addr;
            proxy_set_header REMOTE-HOST $remote_addr;
            proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
            proxy_pass   http://127.0.0.1:9111/wxpay/notify;
        }

	location /qiniu/notify {

            index index.html index.htm;
            root /data/develop/dev.jianghu.lulinggushi.com/jianghu-server/hyperf-skeleton/public;
            proxy_http_version 1.1;
            proxy_set_header Connection "keep-alive";
            proxy_set_header Host $host;
            proxy_set_header X-Real-IP $remote_addr;
            proxy_set_header REMOTE-HOST $remote_addr;
            proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
            proxy_pass   http://127.0.0.1:9111/qiniu/notify;
        }
        
        location /pdd/notify {

            index index.html index.htm;
            root /data/develop/dev.jianghu.lulinggushi.com/jianghu-server/hyperf-skeleton/public;
            proxy_http_version 1.1;
            proxy_set_header Connection "keep-alive";
            proxy_set_header Host $host;
            proxy_set_header X-Real-IP $remote_addr;
            proxy_set_header REMOTE-HOST $remote_addr;
            proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
            proxy_pass   http://127.0.0.1:9111/pdd/notify;
        }

	location /api {

            index index.html index.htm;
            root /data/develop/dev.jianghu.lulinggushi.com/jianghu-server/hyperf-skeleton/public;
            proxy_http_version 1.1;
            proxy_set_header Connection "keep-alive";
            proxy_set_header Host $host;
            proxy_set_header X-Real-IP $remote_addr;
            proxy_set_header REMOTE-HOST $remote_addr;
            proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
            proxy_pass   http://127.0.0.1:9111;
        }

	location /captcha/ {
            expires 30d;
            root /data/develop/dev.jianghu.lulinggushi.com/jianghu-server/hyperf-skeleton/public;
            client_max_body_size  10m;
            client_body_buffer_size 1280k;
            proxy_connect_timeout  900;
            proxy_send_timeout   900;
            proxy_read_timeout   900;
            proxy_buffer_size    40k;
            proxy_buffers      40 320k;
            proxy_busy_buffers_size 640k;
            proxy_temp_file_write_size 640k;
        }
}	
```
