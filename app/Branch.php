<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $table = 'branches';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'code', 'address', 'phone', 'active'];


    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;


    /**
     * Branch has orders
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    
    /**
     * Branch have many user
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'user_branch', 'branch_id', 'user_id');
    }
}
