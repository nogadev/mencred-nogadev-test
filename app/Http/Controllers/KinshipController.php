<?php

namespace App\Http\Controllers;

use App\Models\Kinship;
use App\Http\Requests\KinshipValidator;
use Illuminate\Http\Request;

class KinshipController extends Controller
{
    private $path = 'kinships';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kinships = Kinship::withTrashed()->get();
        return view($this->path.'.index', compact('kinships'));
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
    public function store(KinshipValidator $request)
    {
        try{
            $kinship = new Kinship($request->all());
            $kinship->save();
            session()->put('success','Parentesco guardado');
        } catch (\Exception $e) {
            session()->put('warning','Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kinship  $Kinship
     * @return \Illuminate\Http\Response
     */
    public function show(Kinship $kinship)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kinship  $Kinship
     * @return \Illuminate\Http\Response
     */
    public function edit(Kinship $kinship)
    {
        return view($this->path.'.edit', compact('kinship'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kinship  $Kinship
     * @return \Illuminate\Http\Response
     */
    public function update(KinshipValidator $request, Kinship $kinship)
    {
        try{
            $kinship->fill($request->all());
            $kinship->save();
            session()->put('success','Parentesco modificado');
        } catch (\Exception $e) {
            session()->put('warning','Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kinship  $Kinship
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kinship $kinship)
    {
        try{
            $kinship->delete();
            session()->put('success','Parentesco eliminado');
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
            Kinship::withTrashed()->find($id)->restore();
            session()->put('success','Parentesco restaurado');
        } catch (Exception $e){
            session()->put('error','Se ha producido un error');
        } finally {            
            return redirect()->route($this->path.'.index');
        }
    }
}
