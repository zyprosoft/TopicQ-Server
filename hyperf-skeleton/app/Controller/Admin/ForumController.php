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
            'icon' => 'string|required|min:1|max:500'
        ]);
        $name = $request->param('name');
        $icon = $request->param('icon');
        $result = $this->service->createForum($name,$icon);
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
}