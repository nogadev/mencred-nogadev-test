<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Customer extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['id','name', 'code', 'route_id', 'created_at','updated_at','deleted_at','email','commerce_id','seller_id','commercial_address','commercial_district_id','commercial_town_id','commercial_neighborhood_id','commercial_between','personal_address','personal_district_id','personal_town_id','personal_neighborhood_id','personal_between','doc_number','birthday','horary','marital_status','partner','particular_tel','comercial_tel','contact_tel','cuit','contact','kinship_id','owner', 'defaulter', 'antiquity','observation', 'customer_category_id','sequence_order', 'visitday_id'];

    protected $hidden = ['created_at','updated_at','deleted_at'];

    protected $dates = ['birthday', 'antiquity'];

    protected $defaults = [
        'partner'       => '',
        'particular_tel'=> '',
        'comercial_tel' => '',
        'contact_tel'   => '',
        'cuit'          => '',
        'contact'       => '',
        'observation'   => '',
        'email'         => '',
        'sequence_order'=> 0
    ];


    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model){
            foreach ($model->defaults as $name => $value){
                if((isset($model->{$name}) && is_null($model->{$name})) || !isset($model->{$name})){
                    $model->{$name} = $value;
                }
            }
        });

        static::updating(function ($model){
            foreach ($model->defaults as $name => $value){
                if((isset($model->{$name}) && is_null($model->{$name})) || !isset($model->{$name})){
                    $model->{$name} = $value;
                }
            }
        });
    }

    public function visitday(){
        return $this->belongsTo(VisitDay::Class);
    }

    public function seller(){
        return $this->belongsTo(Seller::Class);
    }

    public function commercial_neighborhood(){
        return $this->belongsTo(Neighborhood::Class,'commercial_neighborhood_id');
    }

    public function personal_neighborhood(){
        return $this->belongsTo(Neighborhood::Class,'personal_neighborhood_id');
    }

    public function route(){
    	return $this->belongsTo(Route::Class);
    }

    public function credits(){
    	return $this->hasMany(Credit::Class)->orderBy('id','DESC');
    }

    public function kinship(){
        return $this->belongsTo(kinship::Class);
    }

    public function commerce(){
    	return $this->belongsTo(Commerce::Class);
    }

    public function commercial_town(){
    	return $this->belongsTo(Town::Class, 'commercial_town_id');
    }

    public function personal_town(){
    	return $this->belongsTo(Town::Class, 'personal_town_id');
    }

    public function activeCredits(){
        return $this->hasMany(Credit::Class)->where('status_id','=', 2);
    }

    public function total_credits(){
        return $this->hasOne(Credit::Class)
            ->selectRaw('customer_id, sum(total_amount) as total_credits, count(id) count_credits')
            ->where('status_id','<>',6) //todos menos los cancelados 
            ->groupBy('customer_id');
    }

    public function total_credits_status($status = 2){
        return $this->hasOne(Credit::Class)
            ->selectRaw('customer_id, sum(total_amount) as total_credits, count(id) count_credits')
            ->where('status_id','=',$status) //todos menos los cancelados 
            ->groupBy('customer_id');
    }

    public function total_paid_status($status = 2){
        return $this->hasOne(Credit::Class)
            ->selectRaw('customer_id, sum(paid_amount) as total_paid')
            ->join('fees','fees.credit_id','=','credits.id')
            ->where('credits.status_id','=',$status) //todos menos los cancelados 
            ->groupBy('customer_id');
    }

    public function total_payment(){
        return $this->hasOne(Credit::Class)
            ->selectRaw('customer_id, sum(payment_amount) as total_payment')
            ->join('fees','fees.credit_id','=','credits.id')
            ->where('credits.status_id','<>',6) //todos menos los cancelados 
            ->groupBy('customer_id');
    }

    public function saldo(){
        $total_credits = $this->total_credits_status->total_credits ?? 0;
        $total_paid = $this->total_paid_status->total_paid ?? 0;
        return $total_credits - $total_paid;
    }

    public function efectivity(){
        $count_credits  = $this->total_credits->count_credits ?? 1;
        $efectivity     = 0;

        foreach($this->credits as $credit)
        {
            if($credit->status_id <> 6)
            {
                $efectivity = $efectivity + $credit->getEfectivity();
            }
        }
        return round( ($efectivity / $count_credits ) ,2);
    }
}
