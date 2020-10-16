<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ClaimTraking extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['id','claim_id','user_id','date_of','observation'];

    protected $hidden = ['created_at','updated_at','deleted_at'];

    protected $dates = ['date_of'];

    public function claim()
    {
    	return $this->belongsTo(Claim::Class);
    }

    public function user()
    {
    	return $this->belongsTo(User::Class);
    }

}
