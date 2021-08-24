<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnlineRequestPrerequisiteInput extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'online_request_id',
        'name',
        'input_id',
        'type',
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at',
    ];
}
