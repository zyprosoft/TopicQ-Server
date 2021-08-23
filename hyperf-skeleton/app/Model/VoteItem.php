<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $vote_item_id 
 * @property int $vote_id 投票ID
 * @property string $content 选项内容
 * @property int $user_count 此选项的用户数量
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class VoteItem extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vote_item';
    protected $primaryKey = 'vote_item_id';
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
    protected $casts = ['vote_item_id' => 'integer', 'vote_id' => 'integer', 'user_count' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}