<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    //
    public function getProductInfo()
    {
        return $this->belongsTo('\App\Model\Product','pro_id_fk');
    }
}
