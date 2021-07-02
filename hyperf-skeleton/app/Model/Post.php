<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\Scout\Searchable;
/**
 * @property int $post_id 
 * @property string $title 标题
 * @property string $summary 概要
 * @property string $content 内容
 * @property string $image_list 图片列表
 * @property int $owner_id 作者
 * @property string $link 超链接
 * @property int $vote_id 投票信息
 * @property int $read_count 阅读数
 * @property int $favorite_count 收藏数
 * @property int $forward_count 转发数
 * @property int $comment_count 评论数
 * @property int $audit_status 0审核中1:审核通过-1:审核不通过
 * @property string $audit_note 审核备注
 * @property int $is_hot 是否热门帖子0否1是
 * @property string $last_comment_time 最新一条评论的时间
 * @property int $sort_index 排序置顶用
 * @property int $is_recommend 是否推荐帖
 * @property string $avatar_list 最近三个用户头像
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property int $join_user_count 参与用户数
 * @property int $machine_audit 机器审核结果:0待审核-1不通过1通过2建议人工复核
 * @property int $manager_audit 管理员审核结果:0待审核-1不通过1通过
 * @property int $text_audit 0待审核1审核通过-1审核不通过
 * @property int $content_audit 0待审核1审核通过-1审核不通过
 * @property int $title_audit 0待审核1审核通过-1审核不通过
 * @property string $image_ids 图片列表获取出来图片ID
 * @property int $program_id 小程序ID
 * @property int $account_id 公众号ID
 * @property int $forum_id 板块ID
 * @property int $recommend_weight 推荐权重
 * @property int $mall_type 0:拼多多1:京东
 * @property string $mall_goods 关联的商品信息
 * @property string $mall_goods_buy_info 商品购买跳转信息
 * @property int $policy_id 填充的授权批次ID
 * @property int $has_video 是否包含视频
 * @property int $is_video_admin 视频是不是管理员的
 * @property int $praise_count 点赞数
 * @property int $voucher_policy_id 代金券批次ID
 * @property int $topic_id 话题ID
 * @property int $only_self_visible 仅自己可见
 * @property int $red_bag_id 红包ID
 * @property string $last_active_time 上一次活跃时间，通过更新帖子，或者回复，可以刷新帖子的活跃时间
 * @property int $ignore_machine_recommend 忽略系统推荐计算权重
 * @property string $rich_content 富文本
 * @property int $circle_id 圈子ID
 * @property int $circle_topic_id 圈话题
 * @property-read \Hyperf\Database\Model\Collection|\App\Model\PostAtUser[] $at_user_list 
 * @property-read \App\Model\User $author 
 * @property-read \App\Model\Circle $circle 
 * @property-read \Hyperf\Database\Model\Collection|\App\Model\PostDocument[] $document_list 
 * @property-read \App\Model\Forum $forum 
 * @property-read \App\Model\SubscribeForumPassword $forum_voucher 
 * @property-read \App\Model\MiniProgram $mini_program 
 * @property-read \App\Model\OfficialAccount $official_account 
 * @property-read \App\Model\Topic $topic 
 * @property-read \App\Model\Vote $vote 
 * @property-read \App\Model\VoucherPolicy $voucher_policy 
 */
class Post extends Model
{
    use Searchable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post';
    protected $primaryKey = 'post_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['post_id' => 'integer', 'owner_id' => 'integer', 'vote_id' => 'integer', 'read_count' => 'integer', 'favorite_count' => 'integer', 'forward_count' => 'integer', 'comment_count' => 'integer', 'audit_status' => 'integer', 'is_hot' => 'integer', 'sort_index' => 'integer', 'is_recommend' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'join_user_count' => 'integer', 'machine_audit' => 'integer', 'manager_audit' => 'integer', 'text_audit' => 'integer', 'content_audit' => 'integer', 'title_audit' => 'integer', 'program_id' => 'integer', 'account_id' => 'integer', 'forum_id' => 'integer', 'recommend_weight' => 'integer', 'mall_type' => 'integer', 'policy_id' => 'integer', 'has_video' => 'integer', 'is_video_admin' => 'integer', 'praise_count' => 'integer', 'voucher_policy_id' => 'integer', 'topic_id' => 'integer', 'only_self_visible' => 'integer', 'red_bag_id' => 'integer', 'ignore_machine_recommend' => 'integer', 'circle_id' => 'integer', 'circle_topic_id' => 'integer'];
    protected $with = ['author', 'topic','circle_topic'];
    protected $hidden = ['recommend_weight', 'ignore_machine_recommend', 'last_active_time'];
    public function author()
    {
        return $this->hasOne(User::class, 'user_id', 'owner_id');
    }
    public function vote()
    {
        return $this->hasOne(Vote::class, 'vote_id', 'vote_id');
    }
    public function mini_program()
    {
        return $this->hasOne(MiniProgram::class, 'program_id', 'program_id');
    }
    public function official_account()
    {
        return $this->hasOne(OfficialAccount::class, 'account_id', 'account_id');
    }
    public function forum()
    {
        return $this->hasOne(Forum::class, 'forum_id', 'forum_id');
    }
    public function forum_voucher()
    {
        return $this->hasOne(SubscribeForumPassword::class, 'policy_id', 'policy_id');
    }
    public function voucher_policy()
    {
        return $this->hasOne(VoucherPolicy::class, 'policy_id', 'voucher_policy_id');
    }
    public function topic()
    {
        return $this->hasOne(Topic::class, 'topic_id', 'topic_id');
    }
    public function toSearchableArray()
    {
        return ['title' => $this->title, 'content' => $this->content];
    }
    public function document_list()
    {
        return $this->hasMany(PostDocument::class, 'post_id', 'post_id');
    }
    public function at_user_list()
    {
        return $this->hasMany(PostAtUser::class, 'post_id', 'post_id');
    }
    public function circle()
    {
        return $this->hasOne(Circle::class, 'circle_id', 'circle_id');
    }
    public function circle_topic()
    {
        return $this->hasOne(CircleTopic::class,'topic_id','circle_topic_id');
    }
}