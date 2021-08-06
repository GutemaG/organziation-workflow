<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static orderBy(string $string, string $string1)
 */
class OnlineRequestTracker extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'online_request_id',
        'started_at',
        'ended_at',
        'token',
    ];

    public function onlineRequest(): BelongsTo
    {
        return $this->belongsTo(OnlineRequest::class);
    }

    public function onlineRequestSteps(): HasMany
    {
        return $this->hasMany(OnlineRequestStep::class);
    }
}
