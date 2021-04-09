<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $vote_id 
 * @property int $total_user 
 * @property string $title 
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class Vote extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vote';
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
    protected $casts = ['vote_id' => 'integer', 'total_user' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}