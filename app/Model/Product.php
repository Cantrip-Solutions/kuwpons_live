<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;



class Product extends Model
{
    public function getCategory()
    {
        return $this->belongsTo('\App\Model\Category','cat_id_fk');
    }

    public function defaultImage()
    {
        return $this->hasOne('\App\Model\ProductImage','pro_id_fk')->where('default_image','=','1');
    }

    public function getImages()
    {
        return $this->hasMany('\App\Model\ProductImage','pro_id_fk')->where('default_image','=','0');
    }

    public function reedemedCoupon()
    {
        return $this->hasMany('\App\Model\Redeems','pro_id_fk')->where('status','=','1');
    }

    public function soldCoupon()
    {
        return $this->hasMany('\App\Model\Orders','pro_id_fk')->where('status','=','1');
    }

    public function getUser()
    {
        return $this->belongsTo('\App\User','u_id_fk');
    }

}
