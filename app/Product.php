<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//    protected $table = 'product';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id', 'name', 'weight', 'price', 'min_age', 'max_age', 'tag', 'image', 'active'];


    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;


    /**
     * Get the products that are associated with the category.
     */
    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }

    /**
     * product called by orders
     */
    public function orders()
    {
        return $this->belongsToMany('App\Order')->withTimestamps();
    }

    /**
     * product has flavors
     */
    public function flavors()
    {
        return $this->belongsToMany('App\Flavour')->withTimestamps();
    }

}
