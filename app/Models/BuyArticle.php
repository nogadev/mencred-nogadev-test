<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class BuyArticle extends Pivot implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'buy_id',
        'article_id',
        //'code',
        //'barcode',
        //'description',
        'item_no',
        'quantity',
        'net',
        'bonus_percentage',
        'bonus',
        'tax_percentage',
        'tax',
        'subtotal'
    ];

    protected $hidden = ['created_at','updated_at','deleted_at'];

    //Relations
    public function buy() {
        return $this->belongsTo(Buy::Class);
    }
    public function article() {
        return $this->belongsTo(Article::Class);
    }
}
