<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'delete_FAQ',
        'update_FAQ',
        'reply_request',
        'add_request_to_FAQ',
        'delete_request',
        'create_bureau',
        'update_bureau',
        'delete_bureau',
        'create_affair',
        'update_affair',
        'delete_affair',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
