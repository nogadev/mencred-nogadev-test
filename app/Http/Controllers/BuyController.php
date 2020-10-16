<?php

namespace App\Http\Controllers;

use App\Models\Buy;
use App\Models\Company;
use App\Models\Supplier;
use App\Models\VoucherType;
use App\Models\Article;
use App\Models\Tax;
use App\Models\Store;
use App\Models\Stock;
use App\Models\ArticleStock;
use App\Traits\DataTrait;
use Illuminate\Http\Request;
use App\Http\Requests\BuyValidator;
use Illuminate\Support\Facades\DB;


class BuyController extends Controller
{
    use DataTrait;

    private $path = 'buys';
    private $companies;
    private $suppliers;
    private $voucherTypes;
    private $articles;
    private $taxes;
    private $stores;
    private $stockController;

    public function __construct(){
        $this->companies    = Company::all();
        $this->suppliers    = Supplier::all();
        $this->voucherTypes = VoucherType::all();
        $this->articles     = Article::all();
        $this->taxes        = Tax::all();
        $this->stores       = Store::all();

        $this->stockController = new StockController();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            ->with('voucherTypes', $this->voucherTypes)
            ->with('companies', $this->companies)
            ->with('articles', $this->articles)
            ->with('taxes', $this->taxes)
            ->with('stores', $this->stores);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BuyValidator $request)
    {
        try {
            DB::beginTransaction();

            $buy = new Buy($request->all());
            $buy->date = date_create_from_format('d/m/Y', $request->date)->format('Y-m-d');
            $buy->save();

            if (isset($request->art_data)){
                $detalle = json_decode($request->art_data);

                foreach ($detalle as $ba) {

                    $article = Article::find($ba->article_id);

                    //actualizo el tipo de iva
                    $article->tax_id        = $ba->tax_id;
                    $article->supplier_id   = $request->supplier_id;
                    $article->available     = 1;
                    $article->save();

                    $buy->articles()->save($article, [
                        'item_no'           => $ba->item_no,
                        'quantity'          => $ba->quantity,
                        'net'               => $ba->net,
                        'bonus_percentage'  => $ba->bonus_percentage,
                        'bonus'             => $ba->bonus,
                        'tax_percentage'    => $ba->tax_percentage,
                        'tax'               => $ba->tax,
                        'subtotal'          => $ba->subtotal,
                        'code'              => $article->code,
                        'description'       => $article->descripcion,
                        'barode'            => $article->barcode
                    ]);

                    $stock = new Stock();
                    $stock->store_id    = $request->store_id;
                    $stock->company_id  = $request->company_id;
                    $stock->date        = $buy->date;
                    $stock->detail      = $buy->voucherType->acronym." ".$buy->subsidiary_number."-".$buy->voucher_number;
                    $stock->quantity    = $ba->quantity;
                    $stock->in_out      = 'I';

                    $article->stocks()->save($stock);

                    $stock_article = $article->articleStocks
                                    ->where('company_id', '=',$request->company_id)
                                    ->where('store_id','=',$request->store_id)
                                    ->first();
                    if(is_null($stock_article))
                    {
                        $stock_article = new ArticleStock();
                        $stock_article->article_id  = $ba->article_id;
                        $stock_article->store_id    = $request->store_id;
                        $stock_article->company_id  = $request->company_id;

                    }
                    $stock_article->stock = $stock_article->stock + $ba->quantity;

                    $stock_article->save();
                }

            }
            DB::commit();
            session()->put('success', 'Compra registrada');
        } catch (\Throwable $th) {
            DB::rollback();
            session()->put('warning', 'Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Buy  $buy
     * @return \Illuminate\Http\Response
     */
    public function show(Buy $buy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Buy  $buy
     * @return \Illuminate\Http\Response
     */
    public function edit(Buy $buy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Buy  $buy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Buy $buy)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Buy  $buy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Buy $buy)
    {
        //
    }

    public function showReportForm() {
        $suppliers = Supplier::all();
        return view('reports.buys.buys')
            ->with('suppliers', $suppliers);
    }

    public function getReportFormData(Request $request)
    {
        $dateInit =  $this->formatDate($request->date_init);
        $dateEnd = $this->formatDate($request->date_end);
        $supplierId = $request->supplier_id;
        $data = $this->getBoughtReportData($dateInit, $dateEnd, $supplierId);
        return response()->json($data);
    }

    public static function getBoughtReportData($dateInit, $dateEnd, $supplierId) {
        return Buy::when($dateInit, function($q) use ($dateInit) {
            $q->where('buys.date', '>=', $dateInit);
        })
            ->when($dateEnd, function($q) use ($dateEnd) {
                $q->where('buys.date', '<=', $dateEnd);
            })
            ->select([
                'suppliers.name as supplier_name',
                'voucher_types.description as voucher_type',
                'buys.subsidiary_number as sell_point',
                'buys.voucher_number',
                'articles.description as article_description',
                'net_1 as net_total_by_voucher',
                'article_buy.net as cost_by_article',
                'buys.date'])
            ->join('suppliers', 'suppliers.id', '=', 'buys.supplier_id')
            ->join('article_buy', 'article_buy.buy_id', '=', 'buys.id')
            ->join('articles', 'articles.id', '=', 'article_buy.article_id')
            ->join('voucher_types', 'voucher_types.code', '=', 'buys.voucher_type_id')
            ->where('suppliers.id', '=', $supplierId)
            ->whereBetween('date', [$dateInit, $dateEnd])->get();
    }
}
