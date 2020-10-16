<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class MovReason extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['id','description','mov_type_id','available'];

    protected $hidden = ['created_at','updated_at','deleted_at'];

    protected $table = 'mov_reasons';

    const IN_RENDICION_COBRANZA = 1;
    const IN_CUOTA_INICIAL = 2;
    const IN_CHEQUE = 5;
    const IN_MERCADOPAGO = 6;
    const IN_BANCO = 7;
    const IN_APERTURA_CAJA = 8;
    const OUT_EGRESO_CHEQUE = 3;
    const OUT_EGRESO_MERCADOPAGO = 4;


    public function movements()
    {
    	return $this->hasMany(CashMov::Class);
    }

    public function mov_types()
    {
        return $this->belongsTo(MovType::Class, 'mov_type_id');
        //return $this->belongsTo(MovType::Class);
    }

}
