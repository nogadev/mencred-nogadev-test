<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Credit;
use App\Models\Seller;
use App\Models\Expense;

use DB;
use App\Traits\RestClientTrait;
use App\Traits\DataTrait;

class SalesController extends Controller
{
	use RestClientTrait;
	use DataTrait;

    public function getPaymentsBySeller(Request $request)
    {
    	$date_init = $this->formatDate($request->date_init);
		$date_end = $this->formatDate($request->date_end);
    	$seller_id  = $request->seller_id ?: null;

    	$payments = Credit::where('init_date','>=', $date_init)
    		->where('init_date','<=', $date_end)
    		->when($seller_id, function($q) use ($seller_id){
    			$q->where('credits.seller_id','=',$seller_id);
    		})
    		->where('status_id','=', 2)
            ->select(['sellers.name as seller','sellers.goal as seller_goal','companies.name as company','credits.init_date','customers.name as customer',
                    'articles.description as article','article_credits.quantity','article_credits.price',DB::Raw('IFNULL(sellers.commission, 0) as commission')])
    		->join('customers','customers.id','=', 'credits.customer_id')
            ->join('sellers','credits.seller_id','=', 'sellers.id')
    		->join('article_credits','article_credits.credit_id','=', 'credits.id')
			->join('articles','article_credits.article_id','=', 'articles.id')
            ->join('companies','companies.id','=', 'article_credits.company_id')
    		->orderBy('credits.init_date')
            ->get();
		
		$expenses = Expense::where('date','>=', $date_init)
			->where('date','<=', $date_end)
			->where('seller_id','=', $seller_id)
			->select(['expenses.*','expense_concepts.name as concept'])
			->join('expense_concepts','expenses.expenseconcept_id','=', 'expense_concepts.id')
			->get();
		
		$data = array(
			'payments' => $payments,
			'expenses' => $expenses
		);

		$this->post('liquidations/seller', json_encode($data), "LiquidacionVendedor.pdf");
	}

	public function getGeneralSales(Request $request)
    {
		
    	$date_init = $this->formatDate($request->date_init);
		$date_end = $this->formatDate($request->date_end);

		$search = $this->replaceSpacesByPercentage($request->search);
        $article  = $this->replaceSpacesByPercentage($request->articulo);
        $date = ($request->fecha) ? $this->formatDate($request->fecha) : "";
		$customer  = (ctype_digit($request->cliente)) ? "" : $this->replaceSpacesByPercentage($request->cliente);
		$customer_DNI = (ctype_digit($request->cliente)) ? $request->cliente : "";
		$company  = $this->replaceSpacesByPercentage($request->empresa);
		$sale_point  = $this->replaceSpacesByPercentage($request->pto_venta);
		$credit  = $this->replaceSpacesByPercentage($request->credito);
		$quantity  = (is_numeric ($request->cantidad)) ? preg_replace("/[^0-9.]/", "", $request->cantidad) : "";
		$price  = (is_numeric ($request->precio)) ? $this->formatMoney($request->precio) : "";
		$total  = (is_numeric ($request->total)) ? $this->formatMoney($request->total) : "";
    	$data = Credit::where('init_date','>=', $date_init)
    		->where('init_date','<=', $date_end)
			->where('status_id','=', 2)
			->where(function($q) use ($search){
				return $q->where('companies.name','like','%'. $search . '%')
						->orWhere('customers.name','like','%'. $search . '%')
						->orWhere('credit_id','like','%'. $search . '%')
						->orWhere('articles.description','like','%'.$search. '%')
						->orWhere('article_credits.quantity','like','%'.$search. '%');
			})
			->where(function($q) use ($article){
                return $q->where('articles.description','like','%'. $article . '%');
			})
			->where(function($q) use ($credit){
                return $q->where('credit_id','like','%'. $credit . '%');
			})
			->where(function($q) use ($customer){
                return $q->where('customers.name','like','%'.$customer. '%');
			})
			->where(function($q) use ($customer_DNI){
                return $q->where('customers.doc_number','like','%'.$customer_DNI. '%');
			})
			->where(function($q) use ($company){
                return $q->where('companies.name','like','%'.$company. '%');
			})
			->where(function($q) use ($quantity){
                return $q->where('article_credits.quantity','like','%'.$quantity. '%');
			})
			->where(function($q) use ($sale_point){
                return $q->where('point_of_sales.name','like','%'.$sale_point. '%');
			})
			->where(function($q) use ($date){
                return $q->where('init_date','like','%'.$date. '%');
			})
			->where(function($q) use ($price){
                return $q->where('article_credits.price','like','%'.$price. '%');
			})
			->where(function($q) use ($total){
                return $q->where('total_amount','like','%'.$total. '%');
			})
            ->select(['companies.name as company','credits.id as credit_id','credits.init_date','customers.name as customer','customers.doc_number as doc_number',
                    'articles.description as article','article_credits.quantity','article_credits.price','point_of_sales.name as point_of_sale'])
    		->join('customers','customers.id','=', 'credits.customer_id')
    		->join('article_credits','article_credits.credit_id','=', 'credits.id')
			->join('articles','article_credits.article_id','=', 'articles.id')
			->join('point_of_sales','point_of_sales.id','=', 'article_credits.point_of_sale_id')
            ->join('companies','companies.id','=', 'article_credits.company_id')
    		->orderBy('credits.id')
            ->get();
		//die(json_encode($data));
		$this->post('credits/sales/general', $data, "VentasGeneral.pdf");
	}
}
