<?php


namespace App\Service\Admin;
use App\Constants\Constants;
use App\Model\Forum;
use App\Model\Good;
use App\Model\Post;
use App\Model\SubscribeForumPassword;
use App\Model\User;
use App\Model\UserGroup;
use App\Service\BaseService;
use Carbon\Carbon;
use Hyperf\DbConnection\Db;
use Hyperf\Utils\Str;
use ZYProSoft\Constants\ErrorCode;
use ZYProSoft\Exception\HyperfCommonException;
use App\Service\ForumService as FrontForumService;
use Hyperf\Di\Annotation\Inject;

class ForumService extends BaseService
{
    /**
     * @Inject
     * @var FrontForumService
     */
    protected FrontForumService $frontService;

    public function getForum(int $forumId)
    {
        $forum = Forum::findOrFail($forumId);
        //补充用户分组
        if(empty($forum->can_post_user_group) && empty($forum->can_access_user_group)) {
            return $forum;
        }
        if (!empty($forum->can_post_user_group)) {
            $postGroupIds = explode(';',$forum->can_post_user_group);
            $postGroupList = UserGroup::findMany($postGroupIds);
            $forum->can_post_user_group = $postGroupList;
        }
        if (!empty($forum->can_access_user_group)) {
            $accessGroupIds = explode(';',$forum->can_access_user_group);
            $accessGroupList = UserGroup::findMany($accessGroupIds);
            $forum->can_access_user_group = $accessGroupList;
        }
        return $forum;
    }

    public function createForum(array $params)
    {
        Db::transaction(function() use ($params){

            $name = data_get($params,'name');
            $icon = data_get($params,'icon');
            $type= data_get($params,'type',0);
            $area= data_get($params,'area');
            $country= data_get($params,'country');
            $parentForumId = data_get($params,'parentForumId');
            $needAuth = data_get($params,'needAuth');
            $goodsId= data_get($params,'goodsId');
            $buyTip= data_get($params,'buyTip');
            $maxMemberCount=data_get($params,'maxMemberCount');
            $unlockPrice=data_get($params,'unlockPrice');
            $pagePath = data_get($params,'pagePath');
            $canPostUserGroup = data_get($params,'canPostUserGroup');
            $canAccessUserGroup = data_get($params,'canAccessUserGroup');

            $forum = Forum::query()->where('name',$name)
                ->where('type',$type)
                ->first();
            if ($forum instanceof Forum) {
                throw new HyperfCommonException(ErrorCode::RECORD_DID_EXIST);
            }
            $forum = new Forum();
            $forum->name = $name;
            $forum->icon = $icon;
            $forum->type = $type;
            if(isset($area)) {
                $forum->area = $area;
            }
            if (isset($country)) {
                $forum->country = $country;
            }
            if (isset($parentForumId)) {
                $forum->parent_forum_id = $parentForumId;
            }
            if (isset($needAuth)) {
                $forum->need_auth = $needAuth;
            }
            if (isset($goodsId)) {
                $forum->goods_id = $goodsId;
            }
            if (isset($buyTip)) {
                $forum->buy_tip = $buyTip;
            }
            if (isset($maxMemberCount)) {
                $forum->max_member_count = $maxMemberCount;
             }
            if (isset($pagePath)) {
                $forum->page_path = $pagePath;
            }
            if (isset($canPostUserGroup) && !empty($canPostUserGroup)) {
                $forum->can_post_user_group = implode(';',$canPostUserGroup);
            }
            if (isset($canAccessUserGroup) && !empty($canAccessUserGroup)) {
                $forum->can_access_user_group = implode(';',$canAccessUserGroup);
            }
            $forum->saveOrFail();
            //绑定对应的板块ID到商品上
            if (isset($goodsId)) {
                $goods = Good::findOrFail($goodsId);
                $goods->bind_forum_id = $forum->forum_id;
                $goods->saveOrFail();
            }
            if(isset($needAuth) && isset($maxMemberCount)) {
                //创建对应授权批次
                $policy = new SubscribeForumPassword();
                $policy->total_count = $maxMemberCount;
                $policy->left_count = $maxMemberCount;
                $policy->forum_id = $forum->forum_id;
                $policy->sn_prefix = Str::upper(Str::random(8));
                if(isset($unlockPrice)) {
                    $policy->price = $unlockPrice;
                }
                $policy->saveOrFail();
            }
        });
        return $this->success();
    }

    public function editForum(array $params)
    {
        $forumId = data_get($params,'forumId');

        $forum = Forum::query()->where('forum_id',$forumId)
            ->first();
        if (!$forum instanceof Forum) {
            throw new HyperfCommonException(ErrorCode::RECORD_NOT_EXIST);
        }
        Db::transaction(function() use ($params,$forum){

            $name = data_get($params,'name');
            $icon = data_get($params,'icon');
            $type= data_get($params,'type',0);
            $area= data_get($params,'area');
            $country= data_get($params,'country');
            $parentForumId = data_get($params,'parentForumId');
            $needAuth = data_get($params,'needAuth');
            $goodsId= data_get($params,'goodsId');
            $buyTip= data_get($params,'buyTip');
            $maxMemberCount=data_get($params,'maxMemberCount');
            $unlockPrice=data_get($params,'unlockPrice');
            $pagePath = data_get($params,'pagePath');
            $canPostUserGroup = data_get($params,'canPostUserGroup');
            $canAccessUserGroup = data_get($params,'canAccessUserGroup');

            if (isset($name)) {
                $forum->name = $name;
            }
            if (isset($icon)) {
                $forum->icon = $icon;
            }
            if (isset($type)) {
                $forum->type = $type;
            }
            if(isset($area)) {
                $forum->area = $area;
            }
            if (isset($country)) {
                $forum->country = $country;
            }
            if (isset($parentForumId)) {
                $forum->parent_forum_id = $parentForumId;
            }
            if (isset($needAuth)) {
                $forum->need_auth = $needAuth;
            }
            if (isset($goodsId)) {
                $forum->goods_id = $goodsId;
            }
            if (isset($buyTip)) {
                $forum->buy_tip = $buyTip;
            }
            if (isset($maxMemberCount)) {
                $forum->max_member_count = $maxMemberCount;
            }
            if (isset($pagePath)) {
                $forum->page_path = $pagePath;
            }
            if (isset($canPostUserGroup) && !empty($canPostUserGroup)) {
                $forum->can_post_user_group = implode(';',$canPostUserGroup);
            }
            if (isset($canAccessUserGroup) && !empty($canAccessUserGroup)) {
                $forum->can_access_user_group = implode(';',$canAccessUserGroup);
            }
            $forum->saveOrFail();
            //绑定对应的板块ID到商品上
            if (isset($goodsId)) {
                $goods = Good::findOrFail($goodsId);
                $goods->bind_forum_id = $forum->forum_id;
                $goods->saveOrFail();
            }
            if(isset($password) && isset($maxMemberCount)) {
                //创建对应授权批次
                $policy = new SubscribeForumPassword();
                $policy->total_count = $maxMemberCount;
                $policy->left_count = $maxMemberCount;
                $policy->forum_id = $forum->forum_id;
                $policy->sn_prefix = Str::upper(Str::random(8));
                if(isset($unlockPrice)) {
                    $policy->price = $unlockPrice;
                }
                $policy->saveOrFail();
            }
        });
        return $this->success();
    }

    public function createForumVoucher(int $forumId, int $count)
    {
        //创建对应授权批次
        $policy = new SubscribeForumPassword();
        $policy->total_count = $count;
        $policy->left_count = $count;
        $policy->forum_id = $forumId;
        $policy->sn_prefix = Str::upper(Str::random(8));
        if(isset($unlockPrice)) {
            $policy->price = $unlockPrice;
        }
        $policy->saveOrFail();
        return $policy;
    }

    public function sendForumVoucherToUser(int $mobile, int $forumId, int $policyId)
    {
        $user = User::query()->where('mobile',$mobile)->firstOrFail();
        return $this->frontService->getUnlockForumSn($forumId, $policyId, $user->user_id);
    }

    public function getForumSubscribeVoucherList(int $pageIndex, int $pageSize)
    {
        $list = SubscribeForumPassword::query()->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->get();
        $total = SubscribeForumPassword::query()->count();

        return ['total'=>$total,'list'=>$list];
    }

    public function createPostForPolicy(int $policyId, string $title, string $content, string $link = null, array $imageList = null, int $forumId = null)
    {
        $post = new Post();
        $post->title = $title;
        $post->content = $content;
        if (mb_strlen($content) < 40) {
            $post->summary = $content;
        } else {
            $post->summary = mb_substr($content, 0, 40);
        }
        if (isset($imageList)) {
            $post->image_list = implode(';',$imageList);
        }
        if (isset($link)) {
            $post->link = $link;
        }
        //固定板块
        if (isset($forumId)) {
            $post->forum_id = $forumId;
        }else{
            $post->forum_id = Constants::FORUM_MAIN_FORUM_ID;
        }
        $post->policy_id = $policyId;
        $post->audit_status = Constants::STATUS_DONE;
        $post->owner_id = $this->userId();//发券只能管理员发布
        $post->saveOrFail();
        return $this->success($post);
    }
}