<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $vote_item_id 
 * @property int $vote_id 
 * @property string $content 
 * @property int $user_count 
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