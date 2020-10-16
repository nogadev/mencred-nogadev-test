<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class PointOfSale extends Model implements Auditable
{

    use \OwenIt\Auditing\Auditable;

    protected $fillable = ["name"];

    public function prices(){
        return $this->hasMany('App\Models\ArticlePrice');
    }

}