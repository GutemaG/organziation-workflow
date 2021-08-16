<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed onlineRequestStep
 */
class NotificationTracker extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'online_request_step_id'
    ];

    public function notifiedUsers(): HasMany
    {
        return $this->hasMany(NotifiedUser::class);
    }

    public function onlineRequestStep(): BelongsTo
    {
        return $this->belongsTo(OnlineRequestStep::class);
    }
}
