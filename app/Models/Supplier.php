<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Supplier extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'code','name','business_name','address','neighborhood_id',
        'town_id','district_id','province_id','country_id','phone',
        'email','comments', 'traveler_id'];
    
    //Relations
    public function neighborhood(){
        return $this->belongsTo('App\Models\Neighborhood');
    }
    public function town(){
        return $this->belongsTo('App\Models\Town');
    }
    public function district(){
        return $this->belongsTo('App\Models\District');
    }
    public function province(){
        return $this->belongsTo('App\Models\Province');
    }
    public function country(){
        return $this->belongsTo('App\Models\Country');
    }
    public function articles(){
        return $this->hasMany('App\Models\Article');
    }
}
