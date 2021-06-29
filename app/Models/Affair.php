<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Affair extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $gurded = [];
    protected $with = ['user','procedures'];

    public function procedures(){
        return $this->hasMany(Procedure::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function preRequest(){
        return $this->belongsTo(PreRequest::class);
    }
}
