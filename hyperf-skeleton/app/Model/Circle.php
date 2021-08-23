<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $circle_id 
 * @property string $name 圈名字
 * @property int $owner_id 圈主
 * @property string $avatar 圈头像
 * @property string $background 圈背景
 * @property int $member_count 成员数量
 * @property int $post_count 帖子数量
 * @property int $is_open 是否公开的圈子
 * @property string $password 圈密码
 * @property int $use_password 是不是使用密码进入
 * @property string $last_active_time 最后活跃时间
 * @property int $category_id 圈分类
 * @property string $introduce 圈介绍
 * @property string $qq QQ群
 * @property string $wechat 微信群
 * @property int $audit_status 0待审核，1审核通过，-1审核不通过
 * @property int $topic_count 圈话题数量
 * @property int $recommend_weight 推荐权重
 * @property string $tags 标签
 * @property int $is_hot 是否热门圈子
 * @property int $is_recommend 是否被推荐的圈子
 * @property int $open_score 使用多少积分加入0的时候无限制
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \App\Model\User $author 
 */
class Circle extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'circle';
    protected $primaryKey = 'circle_id';
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
    protected $casts = ['circle_id' => 'integer', 'owner_id' => 'integer', 'member_count' => 'integer', 'post_count' => 'integer', 'is_open' => 'integer', 'use_password' => 'integer', 'category_id' => 'integer', 'audit_status' => 'integer', 'topic_count' => 'integer', 'recommend_weight' => 'integer', 'is_hot' => 'integer', 'is_recommend' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'open_score' => 'integer'];
    protected $with = ['author'];
    public function author()
    {
        return $this->hasOne(User::class, 'user_id', 'owner_id');
    }
}