<?php

namespace App\Http\Controllers;

use App\Models\Commerce;
use App\Http\Requests\CommerceValidator;
use Illuminate\Http\Request;

class CommerceController extends Controller
{
    private $path = 'commerces';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commerces = Commerce::withTrashed()->get();
        return view($this->path.'.index', compact('commerces'));
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
    public function store(CommerceValidator $request)
    {
        try{
            $commerce = new Commerce($request->all());
            $commerce->save();
            session()->put('success','Comercio guardado');
        } catch (\Exception $e) {
            session()->put('warning','Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Commerce  $commerce
     * @return \Illuminate\Http\Response
     */
    public function show(Commerce $commerce)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Commerce  $commerce
     * @return \Illuminate\Http\Response
     */
    public function edit(Commerce $commerce)
    {
        return view($this->path.'.edit', compact('commerce'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Commerce  $commerce
     * @return \Illuminate\Http\Response
     */
    public function update(CommerceValidator $request, Commerce $commerce)
    {
        try{
            $commerce->fill($request->all());
            $commerce->save();
            session()->put('success','Comercio modificado');
        } catch (\Exception $e) {
            session()->put('warning','Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Commerce  $commerce
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commerce $commerce)
    {
        try{
            $commerce->delete();
            session()->put('success','Comercio eliminado');
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
            Commerce::withTrashed()->find($id)->restore();
            session()->put('success','Comercio restaurado');
        } catch (Exception $e){
            session()->put('error','Se ha producido un error');
        } finally {            
            return redirect()->route($this->path.'.index');
        }
    }
}
