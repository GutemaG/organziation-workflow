<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\OnlineRequest
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OnlineRequestProcedure[] $onlineRequestProcedures
 * @property-read int|null $online_request_procedures_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PrerequisiteLabel[] $prerequisiteLabels
 * @property-read int|null $prerequisite_labels_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\OnlineRequestFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|OnlineRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OnlineRequest newQuery()
 * @method static \Illuminate\Database\Query\Builder|OnlineRequest onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OnlineRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|OnlineRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnlineRequest whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnlineRequest whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnlineRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnlineRequest whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnlineRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OnlineRequest whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|OnlineRequest withTrashed()
 * @method static \Illuminate\Database\Query\Builder|OnlineRequest withoutTrashed()
 * @mixin \Eloquent
 */
class OnlineRequest extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'type',
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
        'onlineRequestProcedures',
        'prerequisiteLabels',
    ];

    /**
     * Get the procedures associated with the online request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function onlineRequestProcedures() {
        return $this->hasMany(OnlineRequestProcedure::class);
    }

    /**
     * Get the prerequisite labels associated with the online request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prerequisiteLabels() {
        return $this->hasMany(PrerequisiteLabel::class);
    }

    /**
     * Get the user that owns the online request.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the onlineRequestTrackers associated with the online request.
     *
     * @return HasMany
     */
    public function onlineRequestTracker(): HasMany
    {
        return $this->hasMany(OnlineRequestTracker::class);
    }
}
