<?php
namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CashMov;
use App\Traits\RestClientTrait;

use DB;

class CashController extends Controller
{
    use RestClientTrait;

	public function getDetails(Request $request)
    {
        $date_init = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_init)));
		$date_end = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_end)));
        $mov_reason_id = $request->mov_reason_id ?: null;
        $search = $request->search;
        
        $data = CashMov::when($date_init, function($q) use ($date_init){
                $q->where('cashes.date_of','>=',$date_init);
            })
            ->when($date_end, function($q) use ($date_end){
                $q->where('cashes.date_of','<=',$date_end);
            })
            ->when($mov_reason_id, function($q) use ($mov_reason_id){
                $q->where('mov_reason_id','=', $mov_reason_id );
            })
            ->select(['cashes.date_of','mov_reasons.description as mov_reason','payment_methods.name as payment_method','cash_movs.description','cash_movs.amount'])
            ->join('cashes','cash_movs.cash_id','=','cashes.id')
            ->join('mov_reasons','cash_movs.mov_reason_id','=','mov_reasons.id')
            ->join('payment_methods','cash_movs.payment_method_id','=','payment_methods.id')
            ->orderBy('cashes.date_of','desc')
            ->get();

        $this->post('cashes', $data, "Caja.pdf");
    }

}

?>