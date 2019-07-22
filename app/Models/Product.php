<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model 
{

    protected $table = 'products';
    public $timestamps = true;
    protected $fillable = array('name', 'description', 'price', 'preparing_time', 'image', 'resturant_id', 'disabled');

    public function resturant()
    {
        return $this->belongsTo('App\Models\Resturant');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\Order');
    }

}