<?php


namespace App\Controller\Admin;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\Admin\ForumService;
use App\Http\AppAdminRequest;
use ZYProSoft\Http\AuthedRequest;

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
            'needAuth' => 'integer|in:0,1',
            'maxMemberCount' => 'integer|required_if:needAuth,1|min:1',
            'unlockPrice' => 'integer|min:0',
            'buyTip' => 'string|required_with:goodsId|min:1|max:500',
            'goodsId' => 'integer|required_with:buyTip|exists:goods,goods_id',//创建付费订阅必选信息
            'pagePath' => 'string|min:1|max:64',//小程序内部跳转的链接
        ]);
        $result = $this->service->createForum($request->getParams());
        return $this->success($result);
    }

    public function editForum(AppAdminRequest $request)
    {
        $this->validate([
            'forumId' => 'integer|required|exists:forum,forum_id',
            'name'=> 'string|min:1|max:24',
            'icon' => 'string|min:1|max:500',
            'needAuth' => 'integer|in:0,1',
            'maxMemberCount' => 'integer|required_if:needAuth,1|min:1',
            'unlockPrice' => 'integer|min:0',
            'buyTip' => 'string|required_with:goodsId|min:1|max:500',
            'goodsId' => 'integer|required_with:buyTip|exists:goods,goods_id',//创建付费订阅必选信息
            'pagePath' => 'string|min:1|max:64',//小程序内部跳转的链接
        ]);
        $result = $this->service->editForum($request->getParams());
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

    public function getForumSubscribeVoucherList(AppAdminRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $result = $this->service->getForumSubscribeVoucherList($pageIndex, $pageSize);
        return $this->success($result);
    }

    public function createPostForPolicy(AppAdminRequest $request)
    {
        $this->validate(
            [
                'title' => 'string|required|min:1|max:40|sensitive',
                'content' => 'string|required|min:1|max:5000|sensitive',
                'imageList' => 'array|min:1|max:4',
                'link' => 'string|min:1|max:500',
                'forumId' => 'integer|exists:forum,forum_id',
                'policyId' => 'integer|required|exists:subscribe_forum_password,policy_id'
            ]
        );
        $title = $request->param('title');
        $content = $request->param('content');
        $link = $request->param('link');
        $imageList = $request->param('imageList');
        $forumId = $request->param('forumId');
        $policyId = $request->param('policyId');
        $result = $this->service->createPostForPolicy($policyId,$title,$content,$link,$imageList,$forumId);
        return $this->success($result);
    }

    public function createForumVoucher(AppAdminRequest $request)
    {
        $this->validate([
            'forumId' => 'integer|required|exists:forum,forum_id',
            'count' => 'integer|required|min:1'
        ]);
        $forumId = $request->param('forumId');
        $count = $request->param('count');
        $result = $this->service->createForumVoucher($forumId,$count);
        return $this->success($result);
    }

    public function sendForumVoucher(AppAdminRequest $request)
    {
        $this->validate([
            'userId' => 'integer|required|exists:user,user_id',
            'forumId' => 'integer|required|exists:forum,forum_id',
            'policyId' => 'integer|required|exists:subscribe_forum_password,policy_id',
        ]);
        $userId = $request->param('userId');
        $forumId = $request->param('forumId');
        $policyId = $request->param('policyId');
        $result = $this->service->sendForumVoucherToUser($userId,$forumId,$policyId);
        return $this->success($result);
    }
}