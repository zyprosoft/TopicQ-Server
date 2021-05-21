<?php


namespace App\Controller\Admin;
use App\Http\AppAdminRequest;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\Admin\SettingService;

/**
 * @AutoController (prefix="/admin/setting")
 * Class AppSettingController
 * @package App\Controller\Admin
 */
class AppSettingController extends AbstractController
{
    /**
     * @Inject
     * @var SettingService
     */
    protected SettingService $service;

    public function updateUserVideo(AppAdminRequest $request)
    {
        $this->validate([
            'status' => 'integer|in:0,1'
        ]);
        $status = $request->param('status');
        $result = $this->service->update('enable_user_video',$status);
        return $this->success($result);
    }

    public function updateUserCreateTopic(AppAdminRequest $request)
    {
        $this->validate([
            'status' => 'integer|in:0,1'
        ]);
        $status = $request->param('status');
        $result = $this->service->update('enable_user_create_topic',$status);
        return $this->success($result);
    }
}