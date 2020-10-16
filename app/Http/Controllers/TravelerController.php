<?php

namespace App\Http\Controllers;

use App\Models\Traveler;
use App\Http\Requests\TravelerValidator;
use Illuminate\Http\Request;

class TravelerController extends Controller
{
    private $path = 'travelers';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $travelers = Traveler::withTrashed()->get();
        return view($this->path.'.index', compact('travelers'));
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
    public function store(TravelerValidator $request)
    {
        try{
            $traveler = new Traveler($request->all());
            $traveler->save();
            session()->put('success','Viajante guardado');
        } catch (\Exception $e) {
            session()->put('warning','Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Traveler  $traveler
     * @return \Illuminate\Http\Response
     */
    public function show(Traveler $traveler)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Traveler  $traveler
     * @return \Illuminate\Http\Response
     */
    public function edit(Traveler $traveler)
    {
        return view($this->path.'.edit', compact('traveler'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Traveler  $traveler
     * @return \Illuminate\Http\Response
     */
    public function update(TravelerValidator $request, Traveler $traveler)
    {
        try{
            $traveler->fill($request->all());
            $traveler->save();
            session()->put('success','Viajante modificado');
        } catch (\Exception $e) {
            session()->put('warning','Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Traveler  $traveler
     * @return \Illuminate\Http\Response
     */
    public function destroy(Traveler $traveler)
    {
        try{
            $store->delete();
            session()->put('success','Viajante eliminado');
        } catch (\Exception $e) {
            session()->put('warning','Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }
}
