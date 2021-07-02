<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'number',
        'number_of_offices',
    ];

    protected $hidden = [
        'updated_at',
        'deleted_at',
    ];
}
