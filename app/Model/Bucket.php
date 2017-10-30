<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Bucket extends Model
{
    //
    public function getProductsInfo()
    {
    	return $this->belongsTo('\App\Model\Product','pro_id_fk');
    }
}
