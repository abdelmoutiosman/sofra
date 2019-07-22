<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classification extends Model 
{

    protected $table = 'classifications';
    public $timestamps = true;
    protected $fillable = array('name');

    public function resturants()
    {
        return $this->belongsToMany('App\Models\Resturant');
    }

}