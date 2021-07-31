<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PrerequisiteLabel
 *
 * @property int $id
 * @property int $online_request_id
 * @property string $label
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\OnlineRequest $request
 * @method static \Database\Factories\PrerequisiteLabelFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|PrerequisiteLabel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PrerequisiteLabel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PrerequisiteLabel query()
 * @method static \Illuminate\Database\Eloquent\Builder|PrerequisiteLabel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrerequisiteLabel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrerequisiteLabel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrerequisiteLabel whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrerequisiteLabel whereOnlineRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PrerequisiteLabel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PrerequisiteLabel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
      'online_request_id',
      'label',
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
     * Get the online request that owns the prerequisite labels.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function request() {
        return $this->belongsTo(OnlineRequest::class);
    }
}
