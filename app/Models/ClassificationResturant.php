<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassificationResturant extends Model 
{

    protected $table = 'classification_resturant';
    public $timestamps = true;
    protected $fillable = array('resturant_id', 'classification_id');

}