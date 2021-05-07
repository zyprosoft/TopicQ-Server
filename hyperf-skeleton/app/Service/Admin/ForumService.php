<?php


namespace App\Service\Admin;
use App\Constants\Constants;
use App\Model\Forum;
use App\Model\Post;
use App\Model\SubscribeForumPassword;
use App\Service\BaseService;
use Carbon\Carbon;
use Hyperf\DbConnection\Db;
use Hyperf\Utils\Str;
use ZYProSoft\Constants\ErrorCode;
use ZYProSoft\Exception\HyperfCommonException;

class ForumService extends BaseService
{
    public function getForum(int $forumId)
    {
        return Forum::findOrFail($forumId);
    }

    public function createForum(string $name,string $icon,
                                int $type=0, string $area=null,
                                string $country=null, int $parentForumId=null,
                                int $needAuth = null, int $goodsId=null,
                                string $buyTip=null, int $maxMemberCount=null,
                                int $unlockPrice=null)
    {
        Db::transaction(function() use ($name,$icon,$type,$area,$country,$parentForumId, $needAuth, $goodsId,$buyTip,$maxMemberCount,$unlockPrice){
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
            $forum->saveOrFail();
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

    public function editForum(int $forumId, string $name = null,string $icon = null,
                              int $type=null, string $area=null,string $country=null,
                              int $parentForumId=null,int $needAuth = null, int $goodsId=null,
                              string $buyTip=null, int $maxMemberCount=null, int $unlockPrice=null)
    {
        $forum = Forum::query()->where('forum_id',$forumId)
            ->first();
        if (!$forum instanceof Forum) {
            throw new HyperfCommonException(ErrorCode::RECORD_NOT_EXIST);
        }
        Db::transaction(function() use ($forum,$name,$icon,$type,$area,$country,$parentForumId, $needAuth, $goodsId,$buyTip,$maxMemberCount,$unlockPrice){
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
            $forum->saveOrFail();
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

    public function getForumSubscribeVoucherList(int $pageIndex, int $pageSize)
    {
        $list = SubscribeForumPassword::query()->offset($pageIndex * $pageSize)
            ->limit($pageSize)
            ->get();
        $total = SubscribeForumPassword::query()->count();

        return ['total'=>$total,'list'=>$list];
    }

    public function createPostForPolicy(int $policyId, string $title, string $content, array $goodsInfo, string $link = null, array $imageList = null, int $forumId = null)
    {
        $post = new Post();
        $post->title = $title;
        $post->content = $content;
        if (mb_strlen($content) < 40) {
            $post->summary = $content;
        } else {
            $post->summary = mb_substr($content, 0, 40);
        }
        $post->mall_goods = json_encode($goodsInfo);
        //商品图片作为图片使用
        if (!isset($imageList)) {
            $post->image_list = data_get($goodsInfo,'image');
        }else{
            //增加商品图片
            $imageList[] = data_get($goodsInfo,'image');
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
        $buyInfo = [];
        $post->mall_goods_buy_info = json_encode($buyInfo);
        $post->mall_type = Constants::MALL_TYPE_SELF;
        $post->audit_status = Constants::STATUS_DONE;
        $post->owner_id = $this->userId();//自营店铺只能管理员发布
        $post->saveOrFail();
        return $this->success($post);
    }
}