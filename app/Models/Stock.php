<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Stock extends  Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'article_id','company_id','store_id','date','detail','quantity','in_out','sender','receiver'
    ];

    //Relations
    public function article() {
        return $this->belongsTo('App\Models\Article');
    }
    public function store() {
        return $this->belongsTo('App\Models\Store');
    }

    public function company() {
        return $this->belongsTo('App\Models\Company');
    }
}