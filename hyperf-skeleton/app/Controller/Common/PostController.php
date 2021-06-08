<?php


namespace App\Controller\Common;
use Qiniu\Auth;
use ZYProSoft\Controller\AbstractController;
use ZYProSoft\Http\AuthedRequest;
use App\Service\PostService;
use  Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\ForumService;

/**
 * @AutoController (prefix="/common/post")
 * Class PostController
 * @package App\Controller\Common
 */
class PostController extends AbstractController
{
    /**
     * @Inject
     * @var PostService
     */
    private PostService $service;

    /**
     * @Inject
     * @var ForumService
     */
    private ForumService $forumService;

    public function create(AuthedRequest $request)
    {
        $this->validate([
            'title' => 'string|required|min:1|max:40|sensitive',
            'content' => 'string|min:1|max:5000|sensitive',
            'imageList' => 'array|min:1|max:4',
            'link' => 'string|min:1|max:500',
            'vote' => 'array|min:1',
            'vote.subject' => 'string|required_with:vote|min:1|max:32|sensitive',
            'vote.items.*.content' => 'string|required_with:vote|min:1|max:32|sensitive',
            'programId' => 'integer|exists:mini_program,program_id',
            'accountId' => 'integer|exists:official_account,account_id',
            'forumId' => 'integer|exists:forum,forum_id',
            'topicId' => 'integer|exists:topic,topic_id',
            'documents' => 'array|min:1|max:9',
            'documents.*.title' => 'string|min:1|max:64',
            'documents.*.link' => 'string|min:1|max:128',
            'documents.*.type' => 'string|min:1|max:24',
            'richContent' => 'array|min:1|required_without:content'
        ]);
        $params = $request->getParams();
        $result = $this->service->create($params);
        return $this->success($result);
    }

    public function delete(AuthedRequest $request)
    {
        $this->validate([
            'postId' => 'integer|required|exists:post,post_id',
        ]);
        $postId = $request->param('postId');
        $result = $this->service->delete($postId);
        return $this->success($result);
    }

    public function update(AuthedRequest $request)
    {
        $this->validate([
            'postId' => 'integer|required|exists:post,post_id',
            'title' => 'string|min:1|max:32|sensitive',
            'content' => 'string|min:1|max:5000|sensitive',
            'imageList' => 'array|min:1|max:4',
            'link' => 'string|min:1|max:500|sensitive',
            'programId' => 'integer|exists:mini_program,program_id',
            'accountId' => 'integer|exists:official_account,account_id',
            'forumId' => 'integer|exists:forum,forum_id',
            'topicId' => 'integer|exists:topic,topic_id',
            'documents' => 'array|min:0|max:9',
            'documents.*.title' => 'string|min:1|max:64',
            'documents.*.link' => 'string|min:1|max:128',
            'documents.*.type' => 'string|min:1|max:24',
            'richContent' => 'array|min:1|required_without:content'
        ]);
        $params = $request->getParams();
        $postId = $request->param('postId');
        $result = $this->service->update($postId, $params);
        return $this->success($result);
    }

    public function vote(AuthedRequest $request)
    {
        $this->validate([
            'postId' => 'integer|required|exists:post,post_id',
            'voteId' => 'integer|required|exists:vote,vote_id',
            'voteItemId' => 'integer|required|exists:vote_item,vote_item_id'
        ]);
        $postId = $request->param('postId');
        $voteItemId = $request->param('voteItemId');
        $voteId = $request->param('voteId');
        $result = $this->service->vote($voteItemId, $postId, $voteId);
        return $this->success($result);
    }

    public function voteDetail()
    {
        $this->validate([
            'voteId' => 'integer|required|exists:vote,vote_id',
        ]);
        $voteId = $this->request->param('voteId');
        $result = $this->service->voteDetail($voteId);
        return $this->success($result);
    }

    public function detail()
    {
        $this->validate([
            'postId' => 'integer|required|exists:post,post_id',
        ]);
        $postId = $this->request->param('postId');
        $result = $this->service->detail($postId);
        return $this->success($result);
    }

    public function list()
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
            'type' => 'integer|required|in:1,2,3,4,5',
        ]);
        $pageIndex = $this->request->param('pageIndex');
        $pageSize = $this->request->param('pageSize');
        $type = $this->request->param('type');
        $result = $this->service->getList($type, $pageIndex, $pageSize);
        return $this->success($result);
    }

    public function listByUser(AuthedRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $result = $this->service->getUserPostList($pageIndex, $pageSize);
        return $this->success($result);
    }

    public function otherUserPostList()
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
            'userId' => 'integer|required|exists:user,user_id',
        ]);
        $pageIndex = $this->request->param('pageIndex');
        $pageSize = $this->request->param('pageSize');
        $userId = $this->request->param('userId');
        $result = $this->service->getUserPostList($pageIndex, $pageSize, $userId);
        return $this->success($result);
    }

    public function favoriteList(AuthedRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $result = $this->service->getUserFavoriteList($pageIndex, $pageSize);
        return $this->success($result);
    }

    public function otherUserFavoriteList()
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
            'userId' => 'integer|required|exists:user,user_id',
        ]);
        $pageIndex = $this->request->param('pageIndex');
        $pageSize = $this->request->param('pageSize');
        $userId = $this->request->param('userId');
        $result = $this->service->getUserFavoriteList($pageIndex, $pageSize, $userId);
        return $this->success($result);
    }

    public function favorite(AuthedRequest $request)
    {
        $this->validate([
            'postId' => 'integer|required|exists:post,post_id',
        ]);
        $postId = $request->param('postId');
        $result = $this->service->favorite($postId);
        return $this->success($result);
    }

    public function report(AuthedRequest $request)
    {
        $this->validate([
            'postId' => 'integer|required|exists:post,post_id',
            'content' => 'string|required|min:1|max:500'
        ]);
        $postId = $request->param('postId');
        $content = $request->param('content');
        $result = $this->service->reportPost($postId, $content);
        return $this->success($result);
    }

    public function markRead(AuthedRequest $request)
    {
        $this->validate([
            'postId' => 'integer|required|exists:post,post_id',
        ]);
        $postId = $request->param('postId');
        $result = $this->service->markRead($postId);
        return $this->success($result);
    }

    public function increaseForward()
    {
        $this->validate([
            'postId' => 'integer|required|exists:post,post_id',
        ]);
        $postId = $this->request->param('postId');
        $result = $this->service->increaseForward($postId);
        return $this->success($result);
    }

    public function getForumList()
    {
        $result = $this->forumService->getForumList();
        return $this->success($result);
    }

    public function getUserPublishForumList(AuthedRequest $request)
    {
        $result = $this->forumService->getUserPublishForumList();
        return $this->success($result);
    }

    public function subscribe(AuthedRequest $request)
    {
        $this->validate([
            'forumId' => 'integer|required|exists:forum,forum_id',
        ]);
        $forumId = $request->param('forumId');
        $result = $this->forumService->subscribe($forumId);
        return $this->success($result);
    }

    public function buySubscribe(AuthedRequest $request)
    {
        $this->validate([
            'forumId' => 'integer|required|exists:forum,forum_id',
        ]);
        $forumId = $request->param('forumId');
        $result = $this->forumService->buyAndSubscribe($forumId);
        return $this->success($result);
    }

    public function unlockSubscribe(AuthedRequest $request)
    {
        $this->validate([
            'unlockSn' => 'string|required|min:1|max:64',
            'policyId' => 'integer|required|exists:subscribe_forum_password,policy_id',
            'forumId' => 'integer|required|exists:forum,forum_id',
        ]);
        $forumId = $request->param('forumId');
        $sn = $request->param('unlockSn');
        $policyId = $request->param('policyId');
        $result = $this->forumService->unlockSubscribe($forumId,$sn,$policyId);
        return $this->success($result);
    }

    public function unsubscribe(AuthedRequest $request)
    {
        $this->validate([
            'forumId' => 'integer|required|exists:forum,forum_id',
        ]);
        $forumId = $request->param('forumId');
        $result = $this->forumService->unsubscribe($forumId);
        return $this->success($result);
    }

    public function getPostListBySubScribed(AuthedRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $result = $this->service->getPostListBySubscribe($pageIndex, $pageSize);
        return $this->success($result);
    }

    public function getPostListBySubScribedForumId(AuthedRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
            'forumId' => 'integer|required|exists:forum,forum_id',
            'type' => 'integer|in:0,1'
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $forumId = $request->param('forumId');
        $type = $request->param('type');
        $result = $this->service->getPostListBySubscribeByForumId($pageIndex, $pageSize, $forumId,$type);
        return $this->success($result);
    }

    public function getPostListByTopicId()
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
            'topicId' => 'integer|required|exists:topic,topic_id',
            'type' => 'integer|in:0,1'
        ]);
        $pageIndex = $this->request->param('pageIndex');
        $pageSize = $this->request->param('pageSize');
        $topicId = $this->request->param('topicId');
        $type = $this->request->param('type');
        $result = $this->service->getPostListByTopicId($pageIndex, $pageSize, $topicId, $type);
        return $this->success($result);
    }

    public function mySubscribeList(AuthedRequest $request)
    {
        $result = $this->forumService->mySubscribeList();
        return $this->success($result);
    }

    public function getMySubscribeVoucherList(AuthedRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $result = $this->forumService->getMySubscribeVoucherList($pageIndex, $pageSize);
        return $this->success($result);
    }

    public function getUnlockForumSn(AuthedRequest $request)
    {
        $this->validate([
            'policyId' => 'integer|required|exists:subscribe_forum_password,policy_id',
            'forumId' => 'integer|required|exists:forum,forum_id',
        ]);
        $policyId = $request->param('policyId');
        $forumId = $request->param('forumId');
        $result = $this->forumService->getUnlockForumSn($forumId,$policyId);
        return $this->success($result);
    }

    public function getVideoPostList(AuthedRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
            'type' => 'integer|in:1,2,3'
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $type = $request->param('type');
        $result = $this->service->getVideoPostList($pageIndex, $pageSize, $type);
        return $this->success($result);
    }

    public function praise(AuthedRequest $request)
    {
        $this->validate([
            'postId' => 'integer|required|exists:post,post_id',
        ]);
        $postId = $request->param('postId');
        $result = $this->service->praise($postId);
        return $this->success($result);
    }

    public function updateOnlySelfVisible(AuthedRequest $request)
    {
        $this->validate([
            'postId' => 'integer|required|exists:post,post_id',
            'status' => 'integer|required|in:0,1'
        ]);
        $postId = $request->param('postId');
        $status = $request->param('status');
        $result = $this->service->updateOnlySelfVisible($postId,$status);
        return $this->success($result);
    }

    public function successForward()
    {
        $this->validate([
            'postId' => 'integer|required|exists:post,post_id',
        ]);
        $postId = $this->request->param('postId');
        $result = $this->service->successForward($postId);
        return $this->success($result);
    }

    public function getForumDetail()
    {
        $this->validate([
            'forumId' => 'integer|required|exists:forum,forum_id'
        ]);
        $forumId = $this->request->param('forumId');
        $result = $this->forumService->getForumDetail($forumId);
        return $this->success($result);
    }

    public function getUserAttentionStatus(AuthedRequest $request)
    {
        $result = $this->service->getUserAttentionStatus();
        return $this->success($result);
    }

    public function praiseList(AuthedRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $result = $this->service->praiseList($pageIndex, $pageSize);
        return $this->success($result);
    }

    public function markPraiseRead(AuthedRequest $request)
    {
        $this->validate([
            'praiseIds' => 'array|required|min:1',
        ]);
        $praiseIds = $request->param('praiseIds');
        $result = $this->service->markPraiseRead($praiseIds);
        return $this->success($result);
    }
}