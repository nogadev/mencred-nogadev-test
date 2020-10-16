<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Store;
use App\Models\Company;
use App\Events\StockMovement;

class StockController extends Controller
{
    private $path = 'stocks';
    private $stores;
    private $companies;

    public function __construct(){
        $this->stores = Store::all();
        $this->companies = Company::all();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        dd('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function store(Stock $stock)
    {
        $stock->save();
        event(new StockMovement($stock));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function transfer()
    {
        return view($this->path.'.transfer')
            ->with('stores', $this->stores)
            ->with('companies', $this->companies);
    }

    /**
     * 
     */
    public function saveTransfers(Request $request) {

        try {
            $array = json_decode($request->art_data);
            foreach ($array as $article) {
                $origin = new Stock();
                $origin->article_id = $article->article_id;
                $origin->store_id   = $request->origin_store_id;
                $origin->company_id = $request->origin_company_id;
                $origin->date       = date_create_from_format('d/m/Y', $request->date)->format('Y-m-d');
                $origin->detail     = $request->details;
                $origin->quantity   = $article->quantity;
                $origin->in_out     = 'O';
                $origin->sender     = $request->sender;
                $origin->receiver   = $request->receiver;

                $this->store($origin);

                $destination = new Stock();
                $destination->article_id= $article->article_id;
                $destination->store_id  = $request->destination_store_id;
                $destination->company_id= $request->destination_company_id;
                $destination->date      = date_create_from_format('d/m/Y', $request->date)->format('Y-m-d');
                $destination->detail    = $request->details;
                $destination->quantity  = $article->quantity;
                $destination->in_out    = 'I';
                $destination->sender    = $request->sender;
                $destination->receiver  = $request->receiver;

                $this->store($destination);
            }

            session()->put('success', 'Transferencia registrada');
        } catch (\Exception $e) {
            session()->put('warning', 'Se ha producido un error'.$e->getMessage());
        } finally {
            return redirect()->route($this->path.'.transfer');
        }        
    }
}
