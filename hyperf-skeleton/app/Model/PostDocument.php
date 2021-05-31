<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $document_id 
 * @property int $post_id 帖子ID
 * @property string $title 文档标题
 * @property string $type 文档类型
 * @property string $icon 文档图标
 * @property string $link 腾讯文档链接
 * @property string $deleted_at 
 */
class PostDocument extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'post_document';
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
    protected $casts = ['document_id' => 'integer', 'post_id' => 'integer'];
}