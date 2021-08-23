<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $user_id 上传者用户ID
 * @property int $owner_id 归属ID
 * @property int $owner_type 归属类型0:帖子1:评论
 * @property string $image_id 图片在空间的唯一文件名
 * @property int $audit_status 审核状态-1:审核不通过,0:审核中,1:审核通过
 * @property string $audit_note 审核备注内容
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 */
class ImageAudit extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'image_audit';
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
    protected $casts = ['id' => 'integer', 'user_id' => 'integer', 'owner_id' => 'integer', 'owner_type' => 'integer', 'audit_status' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}