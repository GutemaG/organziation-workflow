<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    protected $with = ['onlineRequestProcedure'];

    public function onlineRequestProcedure(): BelongsTo
    {
        return $this->belongsTo(OnlineRequestProcedure::class);
    }
}
