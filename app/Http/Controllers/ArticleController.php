<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleStock;
use App\Models\PointOfSale;
use App\Models\Supplier;
use App\Models\ArticleCategory;
use App\Models\Attribute;
use App\Models\ArticleAttribute;
use App\Models\Store;
use App\Models\Company;
use App\Http\Requests\ArticleValidator;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ArticleController extends Controller
{
    private $path = 'articles';
    private $suppliers;
    private $articleCategories;

    public function __construct(){
        $this->suppliers = Supplier::all();
        $this->articleCategories = ArticleCategory::all();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*
    public function index()
    {
        return view($this->path.'.index');
    }
    */

    public function index(Request $request)
    {

        $articles = Article::with(['supplier','articleCategory'])
            ->withTrashed()->get();

        return view($this->path . '.index',compact('articles'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->path.'.create')
            ->with('suppliers', $this->suppliers)
            ->with('articleCategories', $this->articleCategories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleValidator $request)
    {
        try {
            $article = new Article($request->all());
            $article->save();
            if (isset($request->attr_ids)){
                $i = 0;
                foreach ($request->attr_ids as $attr_id) {
                    $articleAttribute = new ArticleAttribute();
                    $articleAttribute->article_id = $article->id;
                    $articleAttribute->attribute_id = $attr_id;
                    $articleAttribute->value = $request->attr_values[$i];
                    $articleAttribute->save();
                    $i++;
                }
            }
            session()->put('success', 'Artículo registrado');
        } catch (\Exception $e) {
            session()->put('warning', 'Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    public function upload()
    {
        //request()->validate(['file' => 'image']); //Validate only img
        //request()->file->storeAs('images/articles', request()->file->getClientOriginalName());
        $fileName = Carbon::now()->timestamp.".".request()->file->getClientOriginalExtension();
        request()->file->storeAs('images/articles', $fileName);
        return Storage::response("images/articles/$fileName");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        return view($this->path.'.edit')
            ->with('article', $article)
            ->with('suppliers', $this->suppliers)
            ->with('articleCategories', $this->articleCategories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        try {

            if(!isset($request->available)) $request->merge(['available' => 0]);

            $article->fill($request->all());
            $article->update();

            if (isset($request->art_attr_ids)){
                $i = 0;
                foreach ($request->art_attr_ids as $art_attr_id) {
                    if ($art_attr_id == 0) {
                        $articleAttribute = new ArticleAttribute();
                        $articleAttribute->article_id = $article->id;
                        $articleAttribute->attribute_id = $request->attr_ids[$i];
                    } else {
                        $articleAttribute = ArticleAttribute::find($art_attr_id);
                    }
                    $articleAttribute->value = $request->attr_values[$i];
                    if ($articleAttribute->value != "") {
                        $articleAttribute->save();
                    }
                    $i++;
                }
            }
            session()->put('success', 'Artículo actualizado');
        } catch (\Exception $e) {
            session()->put('warning', 'Se ha producido un error'.$e->getMessage());
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        try {
            $article->delete();
            session()->put('success', 'Artículo eliminado');
        } catch (\Exception $e) {
            session()->put('warning', 'Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        try {
            Article::withTrashed()->find($id)->restore();
            session()->put('success', 'Artículo restaurado');
        } catch (\Exception $e) {
            session()->put('warning', 'Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Return an article by its code or barcode
     *
     * @param String $code
     * @return \App\Article
     */
    public function getByCode(Request $request){
        $article = Article::whereCodeOrBarcode($request->code,$request->code)->first();
        if ($article == null){
            $article = new Article();
            $article->id = 0;
        }
        return \Response::json($article);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fastStore(ArticleValidator $request)
    {
        try {
            $article = new Article($request->all());
            $article->save();
        } catch (\Exception $e) {
            // TODO with errors
            die(json_encode($e));
        }
        return \Response::json($article);
    }

    public function prices() {
        $point_of_sales = PointOfSale::all();
        return view('prices.index', compact('point_of_sales'));
    }

    public function showPriceList()
    {
        $pathStock = 'reports.articles.pricelist';
        return view($pathStock .'.priceList');
    }

    public function findPriceListData(Request $request)
    {
        $search     = $request->search;
        
        $data = Article::
        when($search, function($q) use ($search){
            return $q->where('trademark','like','%'. $search . '%')
                ->orWhere('model','like','%'. $search . '%')
                ->orWhere('print_name','like','%'. $search . '%');
        })
            ->select(DB::RAW('distinct(print_name) print_name'), 'trademark', 'model', 'fee_quantity', 'fee_amount', 'price_update_level as price_list' ,'price')
            ->where('available', '=', 1)
            ->where('deleted_at', '=', null)
            ->groupBy('print_name', 'trademark', 'model', 'fee_quantity', 'fee_amount', 'price_update_level', 'price')
            ->orderBy('print_name', 'asc')
            ->get();

        return response()->json($data, 200);
    }

    public function fastUpdatePrice(Request $request){

        $article_id = $request->get('article_id');

        try {
            $article = article::find($article_id);
            $article->price = $request->get('price');
            $article->fee_quantity = $request->get('fee_quantity');
            $article->fee_amount = $request->get('fee_amount');
            $article->price_update_level = $request->get('price_update_level');
            $article->print_name = $request->get('print_name');
            $article->save();
            return \Response::json($article);
        } catch (\Exception $e) {
            return \Response::json('msg', 'Se ha producido un error');
        }
    }

    public function findById(Request $request){
        $article = Article::find($request->id);
        return \Response::json($article);
    }
}