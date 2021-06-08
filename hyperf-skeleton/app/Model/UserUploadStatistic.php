<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $owner_id 用户ID
 * @property string $upload_date 哪天上传的
 * @property int $count 获取上传token的次数
 * @property int $disable 今天是不是禁止上传了
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class UserUploadStatistic extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_upload_statistic';
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
    protected $casts = ['id' => 'int', 'owner_id' => 'integer', 'count' => 'integer', 'disable' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}