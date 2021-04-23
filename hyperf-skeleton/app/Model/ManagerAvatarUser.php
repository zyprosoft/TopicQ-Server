<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $owner_id 管理员ID
 * @property int $avatar_user_id 化身用户ID
 * @property string $deleted_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class ManagerAvatarUser extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'manager_avatar_user';
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
    protected $casts = ['id' => 'int', 'owner_id' => 'integer', 'avatar_user_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    protected $with = [
        'avatar_user'
    ];

    public function avatar_user()
    {
        return $this->hasOne(User::class,'user_id','owner_id');
    }
}