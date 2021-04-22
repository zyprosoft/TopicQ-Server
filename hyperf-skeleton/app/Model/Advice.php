<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $owner_id 建议者
 * @property string $content 建议内容
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class Advice extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'advice';
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
    protected $casts = ['id' => 'int', 'owner_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    protected $with = [
        'author'
    ];

    public function author()
    {
        return $this->hasOne(User::class,'user_id','owner_id');
    }
}