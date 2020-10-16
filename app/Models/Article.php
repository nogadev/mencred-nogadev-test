<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Kyslik\ColumnSortable\Sortable;

class Article extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    use Sortable;

    protected $fillable = [
        'barcode','description','print_name','supplier_id','article_category_id','state', 'trademark','model','available','commission','price_update_level','enabled'];

    public $sortable = [
        'barcode','description','print_name','enabled'
    ];

    //Relations
    public function supplier(){
        return $this->belongsTo('App\Models\Supplier');
    }
    public function articleCategory(){
        return $this->belongsTo('App\Models\ArticleCategory');
    }
    public function attributes(){
        return $this->hasMany('App\Models\ArticleAttribute');
    }
    public function buyArticles(){
        return $this->hasMany('App\Models\BuyArticles');
    }
    public function articlePrices(){
        return $this->hasMany(ArticlePrice::Class);
    }
    public function articleStocks(){
        return $this->hasMany(ArticleStock::Class);
    }

    public function buys(){
        return $this->belongsToMany(Buy::Class)->using(BuyArticles::Class);
    }

    public function stocks(){
        return $this->hasMany(Stock::Class);
    }



}
