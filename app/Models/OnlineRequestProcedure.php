<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnlineRequestProcedure extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'online_request_id',
        'responsible_bureau_id',
        'description',
        'step_number',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var string[]
     */
    protected $hidden = [
        'deleted_at',
        'updated_at',
    ];

    /**
     * The relation that should be fetched in each query.
     *
     * @var string[]
     */
    protected $with = [
        'users'
    ];

    /**
     * Get the online request that owns the online request procedure.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function OnlineRequest() {
        return $this->belongsTo(OnlineRequest::class);
    }

    /**
     * Get the user that owns the online request procedure.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users() {
        return $this->belongsToMany(User::class, 'online_request_procedure_users', 'procedure_id', 'user_id');
    }
}
