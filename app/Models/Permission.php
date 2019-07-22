<?php 
namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    protected $table = 'permissions';
    protected $fillable = array('name', 'display_name', 'description','routes');
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }
}