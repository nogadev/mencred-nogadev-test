<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class District extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['name', 'province_id'];

    //Relations
    public function province(){
        return $this->belongsTo('App\Models\Province');
    }

    public function towns(){
        return $this->hasMany('App\Models\Town');
    }
}