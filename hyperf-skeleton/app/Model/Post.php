<?php

declare (strict_types=1);
namespace App\Model;

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
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property int $join_user_count 参与用户数
 * @property-read \App\Model\User $author 
 * @property-read \App\Model\Vote $vote 
 */
class Post extends Model
{
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
    protected $casts = ['post_id' => 'integer', 'owner_id' => 'integer', 'vote_id' => 'integer', 'read_count' => 'integer', 'favorite_count' => 'integer', 'forward_count' => 'integer', 'comment_count' => 'integer', 'audit_status' => 'integer', 'is_hot' => 'integer', 'sort_index' => 'integer', 'is_recommend' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'join_user_count' => 'integer'];

    protected $with = [
        'author'
    ];

    public function author()
    {
        return $this->hasOne(User::class, 'user_id', 'owner_id');
    }
    public function vote()
    {
        return $this->hasOne(Vote::class, 'vote_id', 'vote_id');
    }
}