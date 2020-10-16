<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class MovType extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['id','description'];

    protected $hidden = ['created_at','updated_at','deleted_at'];

    const INGRESO = 1;
    const EGRESO = 2;


    public function movreasons()
    {
    	return $this->hasMany(MovReason::Class)->orderBy('description');
    }

    public function availablesMovreasons()
    {
        return $this->movreasons()->where('available', '=', true);
    }

    public function cashMov()
    {
        return $this->hasOneThrough(CashMov::class, MovReason::class);
    }
}
