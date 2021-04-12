<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $post_id 举报的帖子ID
 * @property int $owner_id 谁举报的
 * @property string $content 举报内容
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class ReportPost extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'report_post';
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
    protected $casts = ['id' => 'integer', 'post_id' => 'integer', 'owner_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}