<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Claim extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;


    const STATUS = [
        'PENDIENTE'=> 7,
        'RESUELTO' => 8,
    ];

    protected $fillable = ['id','credit_id','status_id','init_date','end_date','type'];

    protected $hidden = ['created_at','updated_at','deleted_at'];

    protected $dates = ['init_date','end_date'];



    public function getInitDateLegible()
    {
        return $this->init_date->format('d/m/Y');
    }

    public function getEndDateLegible()
    {
        return $this->end_date->format('d/m/Y');
    }

    public function claimtrakings()
    {
        return $this->hasMany(ClaimTraking::Class);
    }

    public function status()
    {
        return $this->belongsTo(Status::Class);
    }

    public function credit()
    {
        return $this->belongsTo(Credit::Class)
                    ->with(['customer','fees','articles']);
    }

}

?>