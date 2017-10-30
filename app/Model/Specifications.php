<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Specifications extends Model
{
    //
    public function getCategoryInfo()
    {
        return $this->belongsTo('\App\Model\Category','cat_id_fk');
    }
}
