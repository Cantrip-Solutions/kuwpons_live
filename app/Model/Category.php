<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function getProduct()
    {
        return $this->hasMany('\App\Model\Category','cat_id_fk');
    }
}
