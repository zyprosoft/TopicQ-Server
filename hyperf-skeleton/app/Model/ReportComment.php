<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $comment_id 举报的评论ID
 * @property int $owner_id 谁举报的
 * @property string $content 举报内容
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property int $audit_status 0审核中1:审核通过-1:审核不通过
 * @property string $audit_note 审核备注
 * @property-read \App\Model\User $author 
 * @property-read \App\Model\Comment $comment 
 */
class ReportComment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'report_comment';
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
    protected $casts = ['id' => 'integer', 'comment_id' => 'integer', 'owner_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime', 'audit_status' => 'integer'];
    protected $with = ['author', 'comment'];
    public function author()
    {
        return $this->hasOne(User::class, 'user_id', 'owner_id');
    }
    public function comment()
    {
        return $this->hasOne(Comment::class, 'comment_id', 'comment_id');
    }
}