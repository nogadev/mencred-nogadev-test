<?php
namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\ArticleStock;
use App\Models\Article;
use App\Models\Company;

use DB;
use App\Traits\RestClientTrait;

class ArticleStocksController extends Controller
{
    use RestClientTrait;

    public function printPriceList(Request $request)
    {
        $search = str_replace(" ","%",$request->search);
        $article  = str_replace(" ","%",$request->articulo);
        $trademark  = str_replace(" ","%",$request->marca);
        $model  = str_replace(" ","%",$request->modelo);
        $price_list  = str_replace(" ","%",$request->lista);
        $price  = (is_numeric ($request->precio))?number_format((preg_replace("/[^0-9]/", "", $request->precio)), 2, '.', ''):"";
        $data = Article::
            where(function($q) use ($search){
                return $q->where('trademark','like','%'. $search . '%')
                        ->orWhere('model','like','%'. $search . '%')
                        ->orWhere('print_name','like','%'. $search . '%')
                        ->orWhere('price_update_level','like','%'. $search . '%');
            })
            ->where(function($q) use ($article){
                return $q->where('print_name','like','%'. $article . '%');
            })
            ->where(function($q) use ($trademark){
                return $q->where('trademark','like','%'. $trademark . '%');
            })
            ->where(function($q) use ($model){
                return $q->where('model','like','%'. $model . '%');
            })
            ->where(function($q) use ($price_list){
                return $q->where('price_update_level','like','%'. $price_list . '%');
            })
            ->where(function($q) use ($price){
                return $q->where('price','like','%'. $price . '%');
            })
            
            ->select(DB::RAW('distinct(print_name) print_name'), 'trademark', 'model', 'fee_quantity', 'fee_amount', 'price_update_level as price_list' ,'price')
            ->where('available', '=', 1)
            ->where('deleted_at', '=', null)
            ->groupBy('print_name', 'trademark', 'model', 'fee_quantity', 'fee_amount', 'price_update_level', 'price')
            ->orderBy('print_name', 'asc')
            ->get();

        $this->post('articles/price/list', $data, "ListaPrecios.pdf");
    }

    public function printStockList(Request $request)
    {
        $company = $request->empresa;
        $company_id = (empty($company))?null:Company::
            when($company,function($q) use ($company){
                return $q->where('companies.name','like','%'. $company . '%');
            })
            ->value('id');
        $store_id   = $request->store_id;
        $search     = $request->search;
        $article  = str_replace(" ","%",$request->articulo);
        $trademark  = str_replace(" ","%",$request->marca);
        $model  = str_replace(" ","%",$request->modelo);
        $stock  = (is_numeric ($request->stock))?$request->stock:"";

        $data = ArticleStock::
            when($store_id,function($q) use ($store_id){
                return $q->where('article_stocks.store_id','=',$store_id);
            })           
            ->where(function($q) use ($search){
                return $q
                        ->where('articles.trademark','like','%'. $search . '%')
                        ->orWhere('articles.model','like','%'. $search . '%')
                        ->orWhere('articles.description','like','%'. $search . '%');
            })
            ->where(function($q) use ($article){
                return $q->where('articles.print_name','like','%'. $article . '%');
            })
            ->when($company_id, function($q) use ($company_id){
                $q->where('article_stocks.company_id',$company_id);
            })
            ->where(function($q) use ($trademark){
                return $q->where('articles.trademark','like','%'. $trademark . '%');
            })
            ->where(function($q) use ($model){
                return $q->where('articles.model','like','%'. $model . '%');
            })
            ->where(function($q) use ($stock){
                return $q->where('article_stocks.stock','like','%'. $stock . '%');
            })
            ->select('articles.description as description','trademark','model','stock','companies.name as company')
            ->join('articles', 'article_stocks.article_id', '=', 'articles.id')
            ->join('companies', 'article_stocks.company_id', '=', 'companies.id')
            ->where('articles.deleted_at', '=', null)
            ->orderBy('description', 'asc')
            ->get();
        
        $this->post('articles/stock/list', $data, "ListadoStock.pdf");
    }
}
