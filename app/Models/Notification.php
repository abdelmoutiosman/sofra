<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model 
{

    protected $table = 'notifications';
    public $timestamps = true;
    protected $fillable = array('title', 'body', 'order_id', 'notificateable_id', 'notificateable_type' ,'is_read');

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    public function notificateable()
    {
        return $this->morphTo();
    }

}