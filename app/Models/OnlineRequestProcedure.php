<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\OnlineRequestProcedure
 *
 * @property int $id
 * @property int $online_request_id
 * @property int $responsible_bureau_id
 * @property string|null $description
 * @property int $step_number
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\OnlineRequest $OnlineRequest
 * @property-read \App\Models\Building $building
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\OnlineRequestProcedureFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|OnlineRequestProcedure newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OnlineRequestProcedure newQuery()
 * @method static \Illuminate\Database\Query\Builder|OnlineRequestProcedure onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OnlineRequestProcedure query()
 * @method static \Illuminate\Database\Eloquent\Builder|OnlineRequestProcedure whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnlineRequestProcedure whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnlineRequestProcedure whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnlineRequestProcedure whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnlineRequestProcedure whereOnlineRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnlineRequestProcedure whereResponsibleBureauId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnlineRequestProcedure whereStepNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnlineRequestProcedure whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|OnlineRequestProcedure withTrashed()
 * @method static \Illuminate\Database\Query\Builder|OnlineRequestProcedure withoutTrashed()
 * @mixin \Eloquent
 */
class OnlineRequestProcedure extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'online_request_id',
        'responsible_bureau_id',
        'description',
        'step_number',
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

    /**
     * The relation that should be fetched in each query.
     *
     * @var string[]
     */
    protected $with = [
        'users'
    ];

    /**
     * Get the online request that owns the online request procedure.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function OnlineRequest() {
        return $this->belongsTo(OnlineRequest::class);
    }

    /**
     * Get the user that owns the online request procedure.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users() {
        return $this->belongsToMany(User::class, 'online_request_procedure_users', 'procedure_id', 'user_id');
    }

    /**
     * Get the building that owns the online request procedure.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function building() {
        return $this->belongsTo(Building::class, 'responsible_bureau_id');
    }
}
