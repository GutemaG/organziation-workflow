<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\OnlineRequestProcedureUser
 *
 * @property int $procedure_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OnlineRequestProcedureUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OnlineRequestProcedureUser newQuery()
 * @method static \Illuminate\Database\Query\Builder|OnlineRequestProcedureUser onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OnlineRequestProcedureUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|OnlineRequestProcedureUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnlineRequestProcedureUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnlineRequestProcedureUser whereProcedureId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnlineRequestProcedureUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnlineRequestProcedureUser whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|OnlineRequestProcedureUser withTrashed()
 * @method static \Illuminate\Database\Query\Builder|OnlineRequestProcedureUser withoutTrashed()
 * @mixin \Eloquent
 */
class OnlineRequestProcedureUser extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
      'user_id',
      'procedure_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var string[]
     */
    protected $hidden = [
        'deleted_at',
        'updated_at',
    ];
}
