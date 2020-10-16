<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ArticleStock extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ["article_id","store_id","stock", "company_id"];
    
    //Relations
    public function article(){
        return $this->belongsTo('App\Models\Article')->where('deleted_at','=',null);
    }
    
    public function store(){
        return $this->belongsTo('App\Models\Store');
    }

    public function company(){
        return $this->belongsTo('App\Models\Company');
    }
}
