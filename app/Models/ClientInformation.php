<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientInformation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'online_request_tracker_id',
        'name',
        'value',
        'is_file',
    ];

    protected $hidden = [
        'deleted_at',
        'updated_at',
    ];
}
