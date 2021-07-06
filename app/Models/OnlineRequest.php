<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
