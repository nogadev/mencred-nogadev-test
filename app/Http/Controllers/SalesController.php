<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Credit;
use App\Models\Seller;
use App\Models\ArticleCredit;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function showPaymentSeller()
    {
        $path = 'reports.payments.sellers';
        $sellers  = Seller::orderBy('name')->get();
    	return view($path .'.paymentSellers', compact('sellers'));
    }

    public function getPaymentsBySeller(Request $request)
    {
    	$date_init = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_init)));
		$date_end = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_end)));
    	$seller_id  = $request->seller_id ?: null;

    	$data = Credit::where('init_date','>=', $date_init)
    		->where('init_date','<=', $date_end)
    		->when($seller_id, function($q) use ($seller_id){
    			$q->where('credits.seller_id','=',$seller_id);
    		})
    		->where('status_id','=', 2)
            ->select(['sellers.name as seller','sellers.goal as seller_goal','companies.name as company','credits.init_date','customers.name as customer',
                    'articles.description as article','article_credits.quantity','article_credits.price','sellers.commission as seller_commission'])
    		->join('customers','customers.id','=', 'credits.customer_id')
            ->join('sellers','credits.seller_id','=', 'sellers.id')
    		->join('article_credits','article_credits.credit_id','=', 'credits.id')
			->join('articles','article_credits.article_id','=', 'articles.id')
            ->join('companies','companies.id','=', 'article_credits.company_id')
    		->orderBy('credits.init_date')
            ->get();
            
    	return response()->json($data,200);
	}

	// General Sales
	public function showGeneralSales()
    {
        $path = 'reports.credits.sales';
        $sellers  = Seller::all();
    	return view($path .'.generalSales');
	}
	
	public function getGeneralSales(Request $request)
    {
    	$date_init = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_init)));
		$date_end = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_end)));

    	$data = Credit::where('init_date','>=', $date_init)
    		->where('init_date','<=', $date_end)
    		->where('status_id','=', 2)
            ->select(['companies.name as company','credits.init_date','customers.name as customer','customers.doc_number as document',
					'articles.description as article','article_credits.quantity','article_credits.price','point_of_sales.name as point_of_sale',
					'article_credits.billed','credits.id as credit_id', 'article_credits.id as article_credit_id'])
    		->join('customers','customers.id','=', 'credits.customer_id')
    		->join('article_credits','article_credits.credit_id','=', 'credits.id')
			->join('articles','article_credits.article_id','=', 'articles.id')
			->join('point_of_sales','point_of_sales.id','=', 'article_credits.point_of_sale_id')
            ->join('companies','companies.id','=', 'article_credits.company_id')
    		->orderBy('credits.id')
            ->get();
            
    	return response()->json($data,200);
	}

	public function markAsInvoiced(Request $request){
		$invoiced = 0;
		if ($request->invoiced == 'true'){
			$invoiced = 1;
		}
		$invoiced = 
		$action = DB::table('article_credits')
            ->where('id', $request->id)
            ->update(['billed' => $invoiced]);
		if($action) {
			return json_encode(true);
		} else {
			return json_encode(false);
		}
	}
}
