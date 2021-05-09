<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $forum_id 板块ID
 * @property int $type 0主板块1子板块
 * @property int $parent_forum_id 父板块ID
 * @property string $icon 板块图标
 * @property string $name 板块名称
 * @property string $area 板块归属区县
 * @property string $country 板块归属乡镇
 * @property int $sort_index 排序索引，数字越大优先级越高
 * @property int $total_child_count 子板块总数
 * @property int $total_post_count 帖子总数
 * @property string $notice 板块公告
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 * @property int $need_auth 是否需要密码授权
 * @property int $goods_id 绑定商品的ID
 * @property string $buy_tip 付费提示内容
 * @property int $max_member_count 0不限制
 * @property string $page_path 小程序内部跳转链接
 * @property-read \Hyperf\Database\Model\Collection|\App\Model\Forum[] $child_forum_list 
 * @property-read \App\Model\Good $goods 
 * @property-read \App\Model\Forum $parent_forum 
 */
class Forum extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'forum';
    protected $primaryKey = 'forum_id';
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
    protected $casts = ['forum_id' => 'integer', 'type' => 'integer', 'parent_forum_id' => 'integer', 'sort_index' => 'integer', 'total_child_count' => 'integer', 'total_post_count' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'max_member_count' => 'integer', 'need_buy' => 'integer', 'need_auth' => 'integer', 'price' => 'integer', 'goods_id' => 'integer'];
    protected $hidden = ['password'];
    protected $with = ['goods'];
    public function parent_forum()
    {
        return $this->hasOne(Forum::class, 'forum_id', 'parent_forum_id');
    }
    public function child_forum_list()
    {
        return $this->hasMany(Forum::class, 'parent_forum_id', 'forum_id');
    }
    public function goods()
    {
        return $this->hasOne(Good::class, 'goods_id', 'goods_id');
    }
    public function needCheckSubscribe()
    {
        return $this->need_auth == 1 || $this->goods_id > 0;
    }
}