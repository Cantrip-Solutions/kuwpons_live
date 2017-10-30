<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getdefaultUserInfo()
    {
        return $this->hasOne('\App\Model\UserInfo','u_id_fk')->where('default_address_flag','=','1');
    }

    public function getProduct()
    {
        return $this->hasMany('\App\Model\product','u_id_fk');
    }
}
