<?php
namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Models\Credit;

use DB;
use App\Traits\RestClientTrait;
use App\Traits\DataTrait;

class CreditController extends Controller
{
	use RestClientTrait;
	use DataTrait;

    public function findById($creditId = null)
    {
        $credit = Credit::where('id', '=', $creditId)
        	->with(['customer','seller','articles','fees'])
			->first();

		return $credit;
	}

	public function findDetailById($creditId = null)
    {
        $this->post('credits/details', $this->findById($creditId), "DetalleCuotas.pdf");
	}

	public function findCardById($creditId = null)
    {
        $this->post('credits/cards', $this->findById($creditId), "Credito.pdf");
    }

	public function getCollection(Request $request)
    {
		$route_id = $request->route_id;
		$date = $this->formatDate($request->date);

		$credits = Credit::whereIn('status_id', [Status::OPERANDO,Status::PAGARE])
            ->where('init_date', '<=', $date)
			->select(['credits.id','routes.name as route','status.status','credits.fee_quantity', 'credits.total_amount', 'credits.fee_amount', 'customers.name as customer'])
			->join('customers','customers.id','=','credits.customer_id')
			->join('status','status.id','=','credits.status_id')
			->join('routes','routes.id','=','customers.route_id')
            ->where('customers.route_id', '=', $route_id)
            ->orderBy(DB::RAW('status.status, customers.name , credits.id'))
			->get();

		$this->postWithHeader('credits/collection', $credits, $date, "Cobranza.pdf");
    }

	public function getCreditsByRoute(Request $request)
    {
		$date_init = $this->formatDate($request->date_init);
		$date_end = $this->formatDate($request->date_end);
		$route_id  = $request->route_id ?: null;
		
		$search = $this->replaceSpacesByPercentage($request->search);
		$date = ($request->fecha) ? $this->formatDate($request->fecha) : "";
		$customer  = $this->replaceSpacesByPercentage($request->cliente);
		$seller  = $this->replaceSpacesByPercentage($request->vendedor);
		$route  = $this->replaceSpacesByPercentage($request->recorrido);
		$paid  = (is_numeric ($request->cobrado)) ? $this->formatMoney($request->cobrado) : "";
		$saldo  = (is_numeric ($request->saldo)) ? $this->formatMoney($request->saldo) : "";
		$total  = (is_numeric ($request->total)) ? $this->formatMoney($request->total) : "";

    	$data = Credit::where('init_date','>=', $date_init)
    		->where('init_date','<=', $date_end)
    		->when($route_id, function($q) use ($route_id){
				$q->where('customers.route_id','=',$route_id);
			})
			->where(function($q) use ($search){
				$q->where('customers.name','like','%'.$search. '%')
				->orWhere('sellers.name','like','%'. $search . '%')
				->orWhere('routes.name','like','%'. $search . '%');
    		})
			->whereIn('status_id',[Status::OPERANDO])
			->where(function($q) use ($date){
                return $q->where('init_date','like','%'.$date. '%');
			})
			->where(function($q) use ($customer){
                return $q->where('customers.name','like','%'.$customer. '%');
			})
			->where(function($q) use ($seller){
                return $q->where('sellers.name','like','%'.$seller. '%');
			})
			->where(function($q) use ($route){
                return $q->where('routes.name','like','%'.$route. '%');
			})
			->where(function($q) use ($total){
                return $q->where('total_amount','like','%'.$total. '%');
			})
    		->select(['credits.init_date','customers.name as customer','routes.name as route','sellers.name as seller','credits.total_amount','status.status','customers.commercial_address','neighborhoods.name as commercial_neighborhood','towns.name as commercial_town', 'districts.name as commercial_district',DB::RAW('sum(fees.paid_amount) as paid')])
    		->join('customers','customers.id','=', 'credits.customer_id')
    		->join('sellers','customers.seller_id','=', 'sellers.id')
    		->join('routes','customers.route_id','=', 'routes.id')
    		->join('districts','customers.commercial_district_id','=', 'districts.id')
    		->join('neighborhoods','customers.commercial_neighborhood_id','=', 'neighborhoods.id')
    		->join('towns','customers.commercial_town_id','=', 'towns.id')
    		->join('fees','fees.credit_id','=', 'credits.id')
			->join('status','credits.status_id','=', 'status.id')
    		->orderBy('credits.init_date')
			->groupBy('credits.id')
            ->get();

		$this->post('credits/total', $data, "TotalGeneral.pdf");
    }

}

?>
