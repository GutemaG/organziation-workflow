<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Procedure extends Model
{
    use HasFactory, Notifiable, SoftDeletes;
    
    protected $guarded = [];
    protected $with = ['preRequests'];

    protected $hidden = ['deleted_at','updated_at',];

    public function affair(){
        return $this->belongsTo(AFfair::class);
    }
    public function preRequests(){
        return $this->hasMany(PreRequest::class);
    }
    
}
