<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Province extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['name', 'country_id'];

    //Relations
    public function country(){
        return $this->belongsTo('App\Models\Country');
    }

    public function districts(){
        return $this->hasMany('App\District');
    }
}
