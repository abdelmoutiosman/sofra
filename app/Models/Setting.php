<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model 
{

    protected $table = 'settings';
    public $timestamps = true;
    protected $fillable = array('conditons_and_rules', 'about_app', 'facebook_url', 'twitter_url', 'instagram_url', 'commissions');

}