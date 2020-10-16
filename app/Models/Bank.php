<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Bank extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['id','name'];

    protected $hidden = ['created_at','updated_at','deleted_at'];

    const MERCADOPAGO = 1;

    public function payments()
    {
    	return $this->hasMany(PaymentDetail::Class, 'bank_id', 'id');
    }


}
