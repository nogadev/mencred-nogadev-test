<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Http\Requests\SellerValidator;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    private $path = 'sellers';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sellers = Seller::withTrashed()->get();
        return view($this->path.'.index', compact('sellers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->path.'.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SellerValidator $request)
    {
        try{
            $seller = new Seller($request->all());
            $seller->save();
            session()->put('success','Vendedor guardado');
        } catch (\Exception $e) {
            session()->put('warning','Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function show(Seller $seller)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function edit(Seller $seller)
    {
        return view($this->path.'.edit', compact('seller'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function update(SellerValidator $request, Seller $seller)
    {
        try{
            $seller->fill($request->all());
            $seller->save();
            session()->put('success','Vendedor modificado');
        } catch (\Exception $e) {
            session()->put('warning','Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller)
    {
        try{
            $seller->delete();
            session()->put('success','Vendedor eliminado');
        } catch (\Exception $e) {
            session()->put('warning','Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        try{
            Seller::withTrashed()->find($id)->restore();
            session()->put('success','Vendedor restaurado');
        } catch (Exception $e){
            session()->put('error','Se ha producido un error');
        } finally {            
            return redirect()->route($this->path.'.index');
        }
    }

     /**
     * Return an article by its id
     * 
     * @param int $id
     * @return \App\Models\Customer
     */
    public function getById(Request $request){
        $seller = Seller::find($request->id);
        return \Response::json($seller);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fastStore(SellerValidator $request)
    {
        try {
            $seller = new Seller($request->all());
            $seller->save();
        } catch (\Exception $e) {
            // TODO with errors
        }
        return \Response::json($seller);
    }
}
