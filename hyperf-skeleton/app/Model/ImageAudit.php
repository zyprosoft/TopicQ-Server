<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $user_id 
 * @property int $owner_id 
 * @property int $owner_type 
 * @property string $image_id 
 * @property int $audit_status 
 * @property string $audit_note 
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