<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $message_id 
 * @property int $user_id 用户ID
 * @property string $title 通知标题
 * @property string $content 通知内容
 * @property int $is_top 是否置顶0:否1:是
 * @property int $is_read 是否已读0:否1:是
 * @property int $level 级别0:普通1:提醒2:错误:3:严重4:拉黑
 * @property string $level_label 自定义通知标签名
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 * @property string $key_info 存储一些json格式的附加信息
 */
class Notification extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notification';
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
    protected $casts = ['message_id' => 'integer', 'user_id' => 'integer', 'is_top' => 'integer', 'is_read' => 'integer', 'level' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}