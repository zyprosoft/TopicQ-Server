<?php


namespace App\Controller\Admin;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\Admin\ForumService;
use App\Http\AppAdminRequest;

/**
 * @AutoController (prefix="/admin/forum")
 * Class ForumController
 * @package App\Controller\Admin
 */
class ForumController extends AbstractController
{
    /**
     * @Inject
     * @var ForumService
     */
    private ForumService $service;

    public function createForum(AppAdminRequest $request)
    {
        $this->validate([
            'name'=> 'string|required|min:1|max:24',
            'icon' => 'string|required|min:1|max:500',
            'password' => 'string|min:6|max:30',
            'buyTip' => 'string|required_with:goodsId|min:1|max:500',
            'goodsId' => 'integer|required_with:buyTip|exists:goods,goods_id',//创建付费订阅必选信息
        ]);
        $name = $request->param('name');
        $icon = $request->param('icon');
        $password = $request->param('password');
        $buyTip = $request->param('buyTip');
        $goodsId = $request->param('goodsId');
        $result = $this->service->createForum($name,$icon,0,null,null,null,$password,$goodsId,$buyTip);
        return $this->success($result);
    }

    public function editForum(AppAdminRequest $request)
    {
        $this->validate([
            'forumId' => 'integer|required|exists:forum,forum_id',
            'name'=> 'string|required|min:1|max:24',
            'icon' => 'string|required|min:1|max:500'
        ]);
        $forumId = $request->param('forumId');
        $name = $request->param('name');
        $icon = $request->param('icon');
        $result = $this->service->editForum($forumId,$name,$icon);
        return $this->success($result);
    }

    public function getForum(AppAdminRequest $request)
    {
        $this->validate([
            'forumId' => 'integer|required|exists:forum,forum_id',
        ]);
        $forumId = $request->param('forumId');
        $result = $this->service->getForum($forumId);
        return $this->success($result);
    }
}