<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class FileDetails extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['id','url','extension','reference','entity_type_id'];

    protected $hidden = ['created_at','updated_at'];

    const ARTICLE = 1;
    const INVOICE = 2;

    /*public function files()
    {
    	return $this->hasMany(Files::Class);
    }*/
}
