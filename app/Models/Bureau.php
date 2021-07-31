<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Bureau
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $description
 * @property string $building_number
 * @property string $office_number
 * @property string|null $location
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $accountable_to
 * @property-read Bureau $accountableTo
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\BureauFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Bureau newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bureau newQuery()
 * @method static \Illuminate\Database\Query\Builder|Bureau onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Bureau query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bureau whereAccountableTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bureau whereBuildingNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bureau whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bureau whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bureau whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bureau whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bureau whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bureau whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bureau whereOfficeNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bureau whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bureau whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Bureau withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Bureau withoutTrashed()
 * @mixin \Eloquent
 */
class Bureau extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'accountable_to',
        'location',
        'building_number',
        'office_number',
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
     * Get the bureau that owns the bureau.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function accountableTo(){
        return $this->belongsTo(Bureau::class);
    }

    /**
     * Get the user that owns the bureau.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}
