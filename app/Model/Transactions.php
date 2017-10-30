<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    //
    public function getProductsInfo()
    {
        return $this->belongsTo('\App\Model\Product','pro_id');
    }
    public function getUsersInfo()
    {
        return $this->belongsTo('\App\User','u_id_fk');
    }
}
