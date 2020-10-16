<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ArticlePrice extends Model implements Auditable
{

    use \OwenIt\Auditing\Auditable;

    protected $fillable = ["article_id","point_of_sales_id","price","fee_quantity","fee_ammount"];

    public function article(){
        return $this->belongsTo('App\Models\Article');
    }

    public function point_of_sales(){
        return $this->belongsTo('App\Models\PointOfSale');
    }


}