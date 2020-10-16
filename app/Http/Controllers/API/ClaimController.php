<?php
namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Claim;
use App\Models\ClaimTraking;
use App\Traits\RestClientTrait;

use DB;

class ClaimController extends Controller
{
    use RestClientTrait;

	public function getClaimsByStatus(Request $request)
    {
        $status_id = $request->status_id ?: null;
        
        $data = Claim::when($status_id, function($q) use ($status_id){
                $q->where('claims.status_id','=',$status_id);
            })
            ->select(['status.status','claims.type','customers.name as customer','customers.contact_tel','customers.comercial_tel','customers.particular_tel','routes.name as route',
            'sellers.name as seller','credits.id as credit_id'])
            ->join('credits','credits.id','=','claims.credit_id')
            ->join('customers','customers.id','=','credits.customer_id')
            ->join('sellers','customers.seller_id','=', 'sellers.id')
            ->join('routes','customers.route_id','=', 'routes.id')
            ->join('status','claims.status_id','=', 'status.id')
            ->whereIn('credits.status_id',[2,3])
            ->orderBy('claims.id','desc')
            ->get();

        $this->post('claims/list', $data, "ListadoReclamos.pdf");
    }

    public function getClaimByCredit(Request $request)
    {
        $id = $request->id ?: null;
        $claim = Claim::where('id', '=', $id)
            ->with(['credit'])            
            ->first();

        $claimTracking = ClaimTraking::where('claim_id','=', $id)
            ->orderBy('date_of')
            ->get();
        
        $data = [
            'claim' => $claim,
            'tracking' => $claimTracking
        ];
        
        $this->post('claims/detail', json_encode($data), "ReclamoDetalle.pdf");
    }

}

?>