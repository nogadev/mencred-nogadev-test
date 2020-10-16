<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArticleStock;
use App\Models\Store;
use App\Models\Company;
use DB;

class ArticleStocksController extends Controller
{
    private $path = 'articleStocks';

    public function inventory(Request $request)
    {

        $store_id   = $request->get('store_id') ?? 1;
        $company_id = $request->get('company_id') ?? null;
        $stores     = Store::all();
        $companies  = Company::all();
        $articles = [];

        if(!is_null($store_id))
        {            
            $articles= ArticleStock::where('store_id','=',$store_id)
            ->when($company_id,function($q) use ($company_id){
                return $q->where('article_stocks.company_id','=',$company_id);
            })
            ->whereHas("article", function($q){
                $q->where('deleted_at', '=', null);
            })
            ->select(['article_stocks.id as id', 'companies.name as company', 'articles.description as name', 'stock', 'article_stocks.updated_at as updated_at'])
            ->join('companies', 'companies.id', '=', 'article_stocks.company_id')
            ->join('articles', 'articles.id', '=', 'article_stocks.article_id')
            ->get();
        }
        return view($this->path . '.inventory',compact('store_id','company_id','articles', 'stores','companies'));
    }

    public function getByStore(Request $request) {

        $keyword = $request->keyword;
        $stocks = ArticleStock::with('article:id,description,barcode')
            ->where('store_id', '=', $request->store_id)
            ->whereHas("article", function($q) use ($keyword){
                $q->where('description', 'LIKE', "%$keyword%");
            })
            ->get();
        //$stocks = ArticleStock::whereStoreId($request->store_id)->get();

        $response = [];

        foreach ($stocks as $s) {
            $row["product"]     = $s->article->description;
            $row["stock"]       = $s->stock;
            $row["price"]       = $s->price;
            $row["id"]          = $s->article->id;
            $row["code"]        = $s->article->barcode;
            $row["name"]        = "Cod: ". $s->article->id ." Prod: " . $s->article->description . " Stock: " . $s->stock;

            array_push($response, $row);
        }
        return \Response::json($response);
    }

    public function getByStoreAndCompany(Request $request) {

        $keyword = $request->keyword;
        $stocks = ArticleStock::with('article')
            ->where('store_id', '=', $request->store_id)
            ->where('company_id', '=', $request->company_id)
            ->whereHas("article", function($q) use ($keyword){
                $q->where('description', 'LIKE', "%$keyword%");
            })
            ->get();

        $response = [];

        foreach ($stocks as $s) {
            $row["id"]          = $s->article->id;
            $row["product"]     = $s->article->description;
            $row["stock"]       = $s->stock;
            $row["name"]        = $s->article->description . " Stock: " . $s->stock;
            $row["price"]       = $s->article->price;
            array_push($response, $row);
        }
        return \Response::json($response);
    }

    public function getByStoreAndId(Request $request) {

        $article = ArticleStock::with('article:id,description')
            ->where('store_id', '=', $request->store_id)
            ->where('article_id', '=', $request->article_id)
            ->first();
        //$stocks = ArticleStock::whereStoreId($request->store_id)->get();

        $row["article"]     = $article->article;
        $row["stock"]       = $article->stock;
        $row["price"]       = $article->price;

        return \Response::json($row);
    }

    public function getArticlePrices(Request $request) {
        $prices = ArticleStock::whereArticleId($request->article_id)->groupBy('store_id')->get();
        $response = [];
        foreach ($prices as $p) {
            $row["store_id"]    = $p->store->id;
            $row["fee_quantity"]= $p->fee_quantity;
            $row["fee_ammount"] = $p->fee_ammount;
            $row["price"]       = $p->price;
            array_push($response, $row);
        }
        return \Response::json($response);
    }

    public function storePrices(Request $request) {
        $companies = Company::all();
        try {
            foreach ($request->store_ids as $store_id) {
                foreach($companies as $company){
                    $articleStock = ArticleStock::whereArticleIdAndStoreIdAndCompanyId($request->article_id,$store_id, $company->id)->first();
                    if ($articleStock == null) 
                    {
                        $articleStock = new ArticleStock();
                        $articleStock->article_id = $request->article_id;
                        $articleStock->store_id   = $store_id;
                        $articleStock->company_id = $company_id;
                        $articleStock->stock      = 0.00;
                    }
                    $articleStock->fee_quantity = $request["fee_quantity_".$store_id];
                    $articleStock->fee_ammount  = $request["fee_ammount_".$store_id];
                    $articleStock->price        = $request["price_".$store_id];
                    $articleStock->save();
                }
            }
             return response()->json([
                    'message' => 'Precio cargado con éxito',
                    'status' => 200
                ], 200);
        } catch (Exception $e) {
            return response()
                ->json([
                    'message' => $e->getMessage(),
                    'status' => 400
                ], 400);
        }
    }

    public function setStock(Request $request){
        $id = $request->input('id');
        $stock = $request->input('stock');
        if(isset($stock) && is_numeric($stock) && isset($id)){
            $stockModel = ArticleStock::find($id);
            $stockModel->stock = floatval($stock);
            if($stockModel->save()){
                return json_encode(true);
            }else{
                return json_encode(false);
            }
        }

    }

    public function findStockList()
    {
        $pathStock = 'reports.articles.stocks';
        $companies  = Company::all();
    	$stores	= Store::all();

    	return view($pathStock .'.stockList', compact('companies','stores'));
    }

    public function findStockData(Request $request)
    {

        $company_id = $request->company_id;
        $store_id   = $request->store_id;
        $search     = $request->search;

        
        $data = ArticleStock::
            when($store_id,function($q) use ($store_id){
                return $q->where('article_stocks.store_id','=',$store_id);
            })
            /*->when($company_id, function($q) use ($company_id){
                return $q->where('article_stocks.company_id','=',$company_id);
            })*/            
            ->where(function($q) use ($search){
                return $q
                        ->where('articles.trademark','like','%'. $search . '%')
                        ->orWhere('articles.model','like','%'. $search . '%')
                        ->orWhere('articles.description','like','%'. $search . '%');
            })
            ->select('articles.print_name as description','trademark','model','stock','companies.name as company')
            ->join('articles', 'article_stocks.article_id', '=', 'articles.id')
            ->join('companies', 'article_stocks.company_id', '=', 'companies.id')
            ->where('articles.deleted_at','=',null)
            ->orderBy('description', 'asc')
            ->get();
        return response()->json($data, 200);
    }

}
