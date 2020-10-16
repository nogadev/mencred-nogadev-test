<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Status extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'status';

    protected $fillable = ['name'];

    public static $PRUEBA = 7;

    /*
        LOS NUMEROS CORRESPONDEN AL ESTADO
        'A CONFIRMAR' //credito sin activar o a confirmar
        'OPERANDO'   //credito activo
        'PAGARE'     //termino de pagarlo pero todavia no se le lleva el libre deduda
        'CANCELADO'  //el cliente tiene el libre deuda
        'CONTADO'    //el credito se cancelo en el pago inicial
     *
     */

    const A_CONFIRMAR = 1;
    const OPERANDO  = 2;
    const PAGARE = 3;
    const CANCELADO = 4;
    const EN_PROBLEMA = 5;
    const RECHAZADO = 6;
    const PENDIENTE = 7;
    const RESUELTO = 8;
    const CARTERA = 9;
    const ENTREGADO = 10;
    const ABIERTA = 11;
    const CERRADA = 12;
    const CONTADO = 13;
}
