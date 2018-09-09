<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'product_id', 'cust_name', 'cust_email', 'cust_address',
        'cust_phone', 'weight', 'quantity', 'flavor', 'price', 'advance_price', 'order_status' ,
        'delivery_date' ,'delivery_time', 'token_code', 'token_no', 'token_expiry_date',
        'remarks', 'branch_id', 'branch_code', 'user_id', 'active', 'priority', 'image'];


    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'delivery_date'
    ];

    /**
     * Orders are processed by user account
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Order have following products
     */
    public function products()
    {
        return $this->belongsToMany('App\Product')->withTimestamps();
    }


    /**
     * Order have following product's flavor
     */
    public function flavors()
    {
        return $this->belongsToMany('App\Flavour')->withTimestamps();
    }

    /**
     * Order belongs to branch
     */
    public function branch()
    {
        return $this->belongsTo('App\Branch');
    }
    
}
