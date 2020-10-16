<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class PaymentMethod extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['id','name'];

    protected $hidden = ['created_at','updated_at','deleted_at'];

    const EFECTIVO = 1;
    const CHEQUE = 2;
    const MERCADOPAGO= 3;
    const BANCO = 4;


    public function cashmovs()
    {
    	return $this->hasMany(CashMov::Class);
    }

    public function payments()
    {
        return $this->hasMany(PaymentDetail::Class);
    }
}
