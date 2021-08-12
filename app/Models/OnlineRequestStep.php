<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnlineRequestStep extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'online_request_tracker_id',
        'online_request_procedure_id',
        'started_at',
        'ended_at',
        'next_step',
        'user_id',
        'is_completed',
        'is_rejected',
        'reason',
    ];

//   protected $with = ['onlineRequestProcedure'];

    public function onlineRequestTracker(): BelongsTo
    {
        return $this->belongsTo(OnlineRequestTracker::class);
    }

    public function onlineRequestProcedure(): BelongsTo
    {
        return $this->belongsTo(OnlineRequestProcedure::class);
    }

    public function nextStep(): HasOne
    {
        return $this->hasOne(OnlineRequestStep::class, 'id', 'next_step');
    }
}
