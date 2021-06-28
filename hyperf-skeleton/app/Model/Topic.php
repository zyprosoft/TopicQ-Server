<?php

declare (strict_types=1);
namespace App\Model;

use Hyperf\Scout\Searchable;
/**
 * @property int $topic_id 
 * @property string $title 话题标题
 * @property string $introduce 话题介绍
 * @property int $owner_id 谁创建的
 * @property string $image 图片
 * @property string $location 位置
 * @property int $category_id 分类
 * @property int $read_count 阅读数
 * @property int $join_count 参与人数
 * @property int $post_count 帖子数
 * @property int $comment_count 评论数
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 * @property int $recommend_weight 推荐权重
 * @property int $sort_index 置顶
 * @property string $tag 自定义标签
 * @property int $audit_status 0:待审核1通过-1不通过审核状态，话题必须要管理员审核通过
 * @property int $circle_id 归属于哪个圈子
 * @property-read \App\Model\User $author 
 */
class Topic extends Model
{
    use Searchable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'topic';
    protected $primaryKey = 'topic_id';
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
    protected $casts = ['topic_id' => 'integer', 'owner_id' => 'integer', 'category_id' => 'integer', 'read_count' => 'integer', 'join_count' => 'integer', 'post_count' => 'integer', 'comment_count' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'recommend_weight' => 'integer', 'sort_index' => 'integer', 'audit_status' => 'integer', 'circle_id' => 'integer'];
    protected $with = ['author'];
    public function author()
    {
        return $this->hasOne(User::class, 'user_id', 'owner_id');
    }
    public function toSearchableArray()
    {
        return ['title' => $this->title, 'introduce' => $this->introduce, 'author' => $this->author->nickname];
    }
}