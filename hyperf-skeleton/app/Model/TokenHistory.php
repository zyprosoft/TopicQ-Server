<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $owner_id 
 * @property string $token 
 * @property string $token_expire 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property string $deleted_at 
 */
class TokenHistory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'token_history';
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
    protected $casts = ['id' => 'integer', 'owner_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}