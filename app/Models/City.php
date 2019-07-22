<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model 
{

    protected $table = 'cities';
    public $timestamps = true;
    protected $fillable = array('name');

    public function regions()
    {
        return $this->hasMany('App\Models\Region');
    }

    public function resturants()
    {
        return $this->hasMany('App\Models\Resturant');
    }

    public function clients()
    {
        return $this->hasMany('App\Models\Client');
    }

}