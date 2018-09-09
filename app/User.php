<?php

namespace App;


use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends \LaravelAcl\Authentication\Models\User
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    public function getPersistCode()
    {
        if (!$this->persist_code) {
            $this->persist_code = $this->getRandomString();

            // Our code got hashed
            $persistCode = $this->persist_code;

            $this->save();

            return $persistCode;
        }
        return $this->persist_code;
    }


    /**
     * User belong to branch
     */
    public function branches()
    {
        return $this->belongsToMany('App\Branch', 'user_branch', 'user_id', 'branch_id');
    }


    /**
     * User have following orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
