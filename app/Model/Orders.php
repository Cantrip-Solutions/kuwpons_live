<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    //

    public function getUserInfo()
    {
        return $this->belongsTo('\App\User','u_id_fk');
    }

    public function getProductsInfo()
    {
        return $this->belongsTo('\App\Model\Product','pro_id_fk');
    }

    public function getTransactionsInfo()
    {
        return $this->belongsTo('\App\Model\Transactions','trans_id_fk');
    }

    public function getCoupons()
    {
        return $this->hasMany('\App\Model\Redeems','o_id_fk');
    }

    public function getRedeemedCoupons()
    {
        return $this->hasMany('\App\Model\Redeems','o_id_fk')->where('status','=','1');
    }

    public function getNotRedeemedCoupons()
    {
        return $this->hasMany('\App\Model\Redeems','o_id_fk')->where('status','=','0');
    }
}
