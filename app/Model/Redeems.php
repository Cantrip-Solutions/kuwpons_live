<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Redeems extends Model
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

    public function getOrdesInfo()
    {
        return $this->belongsTo('\App\Model\Orders','o_id_fk');
    }
}
