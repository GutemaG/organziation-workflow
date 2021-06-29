<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class PreRequest extends Model
{
    use HasFactory, SoftDeletes, Notifiable;
    
    protected $gurded = [];

    public function procedure(){
        return $this->belongsTo(Procedure::class);
    }

    public function affair(){
        return $this->hasOne(Affair::class);
    }
}
