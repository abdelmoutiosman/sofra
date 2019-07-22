<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model 
{

    protected $table = 'orders';
    public $timestamps = true;
    protected $fillable = array('notes', 'state', 'client_id', 'resturant_id', 'payment_method_id', 'cost', 'address', 'delivery_fee', 'total_price', 'commission', 'net');

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function resturant()
    {
        return $this->belongsTo('App\Models\Resturant');
    }

    public function paymentmethod()
    {
        return $this->belongsTo('App\Models\PaymentMethod','payment_method_id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product')->withPivot('price','quantity','special_order');
    }

    public function notifications()
    {
        return $this->hasMany('App\Models\Notification');
    }
}