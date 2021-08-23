<?php


namespace App\Controller\Common;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\CircleService;
use ZYProSoft\Http\AuthedRequest;

/**
 * @AutoController (prefix="/common/circle")
 * Class CircleController
 * @package App\Controller\Common
 */
class CircleController extends AbstractController
{
    /**
     * @Inject
     * @var CircleService
     */
    protected CircleService $service;

    public function createOrUpdate(AuthedRequest $request)
    {
        $this->validate([
            'name' => 'string|required|min:1|max:10|sensitive',
            'introduce' => 'string|required|min:1|max:500|sensitive',
            'avatar' => 'string|required|min:1|max:256',
            'background' => 'string|required|min:1|max:256',
            'isOpen' => 'integer|in:0,1',
            'openScore' => 'integer|min:1',
            'password' => 'string|min:1|max:8',
            'circleId' => 'integer|exists:circle,circle_id',
            'tags' => 'array|min:1',
            'categoryId' => 'integer|required|exists:circle_category,category_id'
        ]);
        $params = $request->getParams();
        $result = $this->service->createOrUpdate($params);
        return $this->success($result);
    }

    public function joinCircle(AuthedRequest $request)
    {
        $this->validate([
            'circleId' => 'integer|required|exists:circle,circle_id',
            'password' => 'string|min:1|max:8',
            'note' => 'string|min:1|max:24',
        ]);
        $circleId = $request->param('circleId');
        $password = $request->param('password');
        $note = $request->param('note');
        $result = $this->service->joinCircle($circleId,$password,$note);
        return $this->success($result);
    }

    public function cancelCircle(AuthedRequest $request)
    {
        $this->validate([
            'circleId' => 'integer|required|exists:circle,circle_id',
        ]);
        $circleId = $request->param('circleId');
        $result = $this->service->cancelCircle($circleId);
        return $this->success($result);
    }

    public function getApplyList(AuthedRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30'
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $result = $this->service->getJoinApplyList($pageIndex,$pageSize);
        return $this->success($result);
    }

    public function auditJoinApply(AuthedRequest $request)
    {
        $this->validate([
            'applyId' => 'integer|required|exist:join_circle_apply,id',
            'status' => 'integer|required|in:-1,1'
        ]);
        $applyId = $request->param('applyId');
        $status = $request->param('status');
        $result = $this->service->auditJoinApply($applyId,$status);
        return $this->success($result);
    }

    public function getCircleByCategory()
    {
        $this->validate([
            'categoryId' => 'integer|required|exists:circle_category,category_id',
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30'
        ]);
        $categoryId = $this->request->param('categoryId');
        $pageIndex = $this->request->param('pageIndex');
        $pageSize = $this->request->param('pageSize');
        $result = $this->service->getCircleByCategory($categoryId,$pageIndex,$pageSize);
        return $this->success($result);
    }

    public function getCircleCategoryList()
    {
        $result = $this->service->getCircleCategoryList();
        return $this->success($result);
    }

    public function getCircleInfoById()
    {
        $this->validate([
            'circleId' => 'integer|required|exists:circle,circle_id',
        ]);
        $circleId = $this->request->param('circleId');
        $result = $this->service->getCircleInfoById($circleId);
        return $this->success($result);
    }

    public function getTopicListByCircleId()
    {
        $this->validate([
            'circleId' => 'integer|required|exists:circle,circle_id',
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30'
        ]);
        $circleId = $this->request->param('circleId');
        $pageIndex = $this->request->param('pageIndex');
        $pageSize = $this->request->param('pageSize');
        $result = $this->service->getTopicListByCircleId($circleId,$pageIndex,$pageSize);
        return $this->success($result);
    }

    public function getCircleMemberListByCircleId()
    {
        $this->validate([
            'circleId' => 'integer|required|exists:circle,circle_id',
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30'
        ]);
        $circleId = $this->request->param('circleId');
        $pageIndex = $this->request->param('pageIndex');
        $pageSize = $this->request->param('pageSize');
        $result = $this->service->getCircleMemberList($circleId,$pageIndex,$pageSize);
        return $this->success($result);
    }

    public function getIndexRecommendList()
    {
        $result = $this->service->getCircleIndexRecommendList();
        return $this->success($result);
    }

    public function getIndexRecommendTopicList()
    {
        $result = $this->service->getIndexRecommendTopicList();
        return $this->success($result);
    }

    public function getOtherUserCircleList()
    {
        $this->validate([
            'userId' => 'integer|required|exists:user,user_id',
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30'
        ]);
        $userId = $this->request->param('userId');
        $pageIndex = $this->request->param('pageIndex');
        $pageSize = $this->request->param('pageSize');
        $result = $this->service->getCircleByUserId($pageIndex,$pageSize,$userId);
        return $this->success($result);
    }

    public function getMyCircleList(AuthedRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30'
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $result = $this->service->getCircleByUserId($pageIndex,$pageSize);
        return $this->success($result);
    }

    public function getAllCircleBySort()
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30'
        ]);
        $pageIndex = $this->request->param('pageIndex');
        $pageSize = $this->request->param('pageSize');
        $result = $this->service->getAllCircleBySort($pageIndex,$pageSize);
        return $this->success($result);
    }
}