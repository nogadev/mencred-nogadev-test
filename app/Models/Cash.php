<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Cash extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['id','date_of','balance','status_id'];

    protected $hidden = ['created_at','updated_at','deleted_at'];

    public function movements()
    {
        return $this->hasMany('App\Models\CashMov');
    }

    public function payments_methods()
    {
        return $this->belongsToMany('App\Models\PaymentMethod','cash_payment_methods');
    }

    public function totalChecks() {
        return $this->payments_methods()->where('payment_method_id','=', PaymentMethod::CHEQUE)
            ->withPivot('amount');
    }

    public function totalMercadopago() {
        return $this->payments_methods()->where('payment_method_id','=', PaymentMethod::MERCADOPAGO)
            ->withPivot('amount');
    }

    public function totalBanks() {
        return $this->payments_methods()->where('payment_method_id','=', PaymentMethod::BANCO)
            ->withPivot('amount');
    }

    public function totalEfectivo() {
        return $this->payments_methods()->where('payment_method_id','=', PaymentMethod::EFECTIVO)
            ->withPivot('amount');
    }

    private function totalOpenCash(){
        return $this->hasMany(CashMov::Class)
            ->selectRaw('cash_id, amount')
            ->where('mov_reason_id','=',MovReason::IN_APERTURA_CAJA)
            ->groupBy('cash_id', 'payment_method_id');
    }

    public function totalOpenChecks(){
        return $this->totalOpenCash()->where('payment_method_id','=',PaymentMethod::CHEQUE);
    }

    public function totalOpenMercadoPago(){
        return $this->totalOpenCash()->where('payment_method_id','=',PaymentMethod::MERCADOPAGO);
    }

    public function totalOpenBank(){
        return $this->totalOpenCash()->where('payment_method_id','=',PaymentMethod::BANCO);
    }

    public function totalOpenEfectivo(){
        return $this->totalOpenCash()->where('payment_method_id','=',PaymentMethod::EFECTIVO);
    }


    public function ingresos(){
        return $this->hasOne(CashMov::Class)
            ->selectRaw('cash_id, sum(amount) as total')
            ->join('mov_reasons', 'cash_movs.mov_reason_id', '=', 'mov_reasons.id')
            ->where('mov_reasons.mov_type_id','=',1)
            ->groupBy('cash_id');
    }

    public function egresos(){
        return $this->hasOne(CashMov::Class)
            ->join('mov_reasons', 'cash_movs.mov_reason_id', '=', 'mov_reasons.id')
            ->where('mov_reasons.mov_type_id','=',2)
            ->groupBy('cash_id');
    }

    public function totalInput(){
        return $this->hasMany(CashMov::Class)
            ->selectRaw('ifnull(sum(amount),0) as total')
            ->join('mov_reasons', 'cash_movs.mov_reason_id', '=', 'mov_reasons.id')
            ->where('mov_type_id','=',MovType::INGRESO);
    }

    public function totalOutput(){
        return $this->hasMany(CashMov::Class)
            ->selectRaw('ifnull(sum(amount),0) as total')
            ->join('mov_reasons', 'cash_movs.mov_reason_id', '=', 'mov_reasons.id')
            ->where('mov_type_id','=',MovType::EGRESO);
    }

    public function totalInputChecks(){
        return $this->totalInput()
            ->where('payment_method_id', '=', PaymentMethod::CHEQUE);
    }

    public function totalInputMercadopago(){
        return $this->totalInput()
            ->where('payment_method_id', '=', PaymentMethod::MERCADOPAGO);
    }

    public function totalInputBank(){
        return $this->totalInput()
            ->where('payment_method_id', '=', PaymentMethod::BANCO);
    }

    public function totalInputMoneyCash(){
        return $this->totalInput()
            ->where('payment_method_id', '=', PaymentMethod::EFECTIVO);
    }

    public function totalOutputChecks(){
        return $this->totalOutput()
            ->where('payment_method_id', '=', PaymentMethod::CHEQUE);
    }

    public function totalOutputMercadopago(){
        return $this->totalOutput()
            ->where('payment_method_id', '=', PaymentMethod::MERCADOPAGO);
    }

    public function totalOutputBank(){
        return $this->totalOutput()
            ->where('payment_method_id', '=', PaymentMethod::BANCO);
    }

    public function totalOutputMoneyCash(){
        return $this->totalOutput()
            ->where('payment_method_id', '=', PaymentMethod::EFECTIVO);
    }

    public function getBalance()
    {
        //$ingresos = ($this->ingresos)? $this->ingresos->total : 0;
        //$egresos = ($this->egresos)? $this->egresos->total : 0;
        $income = 0;
        $expenses = 0;
        $this->balance = $income - $expenses;
        $this->save();
    }

}
