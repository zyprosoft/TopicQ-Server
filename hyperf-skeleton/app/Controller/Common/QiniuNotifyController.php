<?php


namespace App\Controller\Common;

use App\Service\QiniuAuditService;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;

/**
 * @AutoController (prefix="/qiniu")
 * Class QiniuNotifyController
 * @package App\Controller\Common
 */
class QiniuNotifyController extends AbstractController
{
    /**
     * @Inject
     * @var QiniuAuditService
     */
    private QiniuAuditService $service;

    public function notify()
    {
        $params = $this->request->getParams();
        $code = data_get($params, 'code');
        if ($code !== 0) {
            return $this->success();
        }
        $imageID = data_get($params, 'inputKey');
        $auditResult = data_get($params, 'items.0.result');
        $result = $this->service->checkAuditImageID($imageID, $auditResult);
        return $this->success($result);
    }
}