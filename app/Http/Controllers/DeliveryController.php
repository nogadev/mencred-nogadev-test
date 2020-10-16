<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Http\Requests\DeliveryValidator;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    private $path = 'deliveries';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliveries = Delivery::withTrashed()->get();
        return view($this->path.'.index', compact('deliveries'));
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
    public function store(DeliveryValidator $request)
    {
        try{
            $delivery = new Delivery($request->all());
            $delivery->save();
            session()->put('success','Entrega guardado');
        } catch (\Exception $e) {
            session()->put('warning','Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function show(Delivery $delivery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function edit(Delivery $delivery)
    {
        return view($this->path.'.edit', compact('delivery'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function update(DeliveryValidator $request, Delivery $delivery)
    {
        try{
            $delivery->fill($request->all());
            $delivery->save();
            session()->put('success','Entrega modificado');
        } catch (\Exception $e) {
            session()->put('warning','Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Delivery $delivery)
    {
        try{
            $delivery->delete();
            session()->put('success','Entrega eliminado');
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
            Delivery::withTrashed()->find($id)->restore();
            session()->put('success','Entrega restaurado');
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
        $delivery = Delivery::find($request->id);
        return \Response::json($delivery);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fastStore(DeliveryValidator $request)
    {
        try {
            $delivery = new Delivery($request->all());
            $delivery->save();
        } catch (\Exception $e) {
            // TODO with errors
        }
        return \Response::json($delivery);
    }
}
