<?php

declare (strict_types=1);
namespace App\Model;

/**
 * @property int $id 
 * @property int $user_id 申请ID
 * @property int $circle_id 圈子ID
 * @property int $circle_owner_id 圈主ID
 * @property string $note 留言
 * @property int $audit_status 0待审核1通过-1不通过
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class JoinCircleApply extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'join_circle_apply';
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
    protected $casts = ['id' => 'int', 'user_id' => 'integer', 'circle_id' => 'integer', 'circle_owner_id' => 'integer', 'audit_status' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    protected $with = [
        'circle',
    ];

    public function circle()
    {
        return $this->hasOne(Circle::class,'circle_id','circle_id');
    }
}