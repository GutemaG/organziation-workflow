<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnlineRequestPrerequisiteNote extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'online_request_id',
      'note',
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at',
    ];
}
