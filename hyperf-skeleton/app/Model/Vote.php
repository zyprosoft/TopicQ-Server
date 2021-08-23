<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $vote_id 
 * @property int $total_user 总参与人数
 * @property string $title 投票主题
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 * @property-read \Hyperf\Database\Model\Collection|\App\Model\VoteItem[] $items 
 */
class Vote extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vote';
    protected $primaryKey = 'vote_id';
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
    protected $with = ['items'];
    public function items()
    {
        return $this->hasMany(VoteItem::class, 'vote_id', 'vote_id');
    }
}