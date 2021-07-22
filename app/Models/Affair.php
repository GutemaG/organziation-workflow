<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Affair extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $guarded = [];
    protected $with = ['user','procedures'];
    
    protected $hidden = ['deleted_at', 'updated_at'];

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
