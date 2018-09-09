<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Flavour extends Model
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $table = 'flavours';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'active'];


    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;


    /**
     * flavors belong to products
     */
    public function products()
    {
        return $this->belongsToMany('App\Product')->withTimestamps();
    }

    /**
     * flavors belong to order's products
     */
    public function orders()
    {
        return $this->belongsToMany('App\Order')->withTimestamps();
    }

    
}
