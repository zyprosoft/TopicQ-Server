<?php


namespace App\Job;
use App\Constants\Constants;
use App\Model\Notification;
use App\Model\Shop;
use App\Service\NotificationService;
use App\Service\OrderService;
use Hyperf\AsyncQueue\Job;
use Hyperf\Utils\ApplicationContext;
use ZYProSoft\Log\Log;

class AddShopNotificationJob extends Job
{
    public int $shopId;

    public string $title;

    public string $content;

    public bool $isTop;

    public int $level;

    public string $levelLabel;

    public function __construct(int $shopId, string $title, string $content, $isTop = false, int $level = Constants::MESSAGE_LEVEL_NORMAL, string $levelLabel = '')
    {
        $this->shopId = $shopId;
        $this->title = $title;
        $this->content = $content;
        $this->isTop = $isTop;
        $this->level = $level;
        $this->levelLabel = $levelLabel;
    }

    /**
     * @inheritDoc
     */
    public function handle()
    {
        $service = ApplicationContext::getContainer()->get(NotificationService::class);
        //获取店主
        $shop = Shop::findOrFail($this->shopId);
        $ownerId = $shop->owner_id;
        $keyInfo = [
            'shop_id' => $this->shopId,
        ];
        $service->create($ownerId, $this->title, $this->content, $this->isTop, $this->level, $this->levelLabel, json_encode($keyInfo));
        Log::info("店铺($this->shopId) 增加消息($this->content)通知异步执行完成!");
    }
}