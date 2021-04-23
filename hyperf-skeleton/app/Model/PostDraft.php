<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $draft_id 
 * @property string $title 标题
 * @property string $summary 概要
 * @property string $content 内容
 * @property string $image_list 图片列表
 * @property int $owner_id 作者
 * @property string $link 超链接
 * @property string $vote 投票信息json数据
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class PostDraft extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post_draft';
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
    protected $casts = ['draft_id' => 'integer', 'owner_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}