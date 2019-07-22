<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Resturant extends Authenticatable
{

    protected $table = 'resturants';
    public $timestamps = true;
    protected $fillable = array('name', 'city_id', 'email', 'password', 'classification_id', 'minimum_order', 'delivery_cost', 'phone', 'whattsapp', 'image', 'activated', 'pin_code', 'availability');

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function offers()
    {
        return $this->hasMany('App\Models\Offer');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function classifications()
    {
        return $this->belongsToMany('App\Models\Classification');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function notifications()
    {
        return $this->morphMany('App\Models\Notification', 'notificateable');
    }

    public function tokens()
    {
        return $this->morphMany('App\Models\Token', 'tokenable');
    }

    public function contacts()
    {
        return $this->morphMany('App\Models\Contact', 'contactable');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }
    protected $hidden = [
        'password', 'api_token',
    ];

}