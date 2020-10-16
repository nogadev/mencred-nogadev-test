<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Store extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['name', 'address'];

    //Relations
    public function stocks() {
        return $this->hasMany('App\Models\Stock');
    }
    public function articleStocks(){
        return $this->hasMany('App\Models\ArticleStock');
    }
}
