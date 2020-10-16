<?php

namespace App\Http\Controllers;

use App\Models\Neighborhood;
use App\Models\Town;
use Illuminate\Http\Request;
use App\Http\Requests\NeighborhoodValidator;

class NeighborhoodController extends Controller
{
    private $path = 'neighborhoods';
    private $towns;

    public function __construct(){
        $this->towns = Town::orderBy('district_id')->orderBy('name')->get();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword    = $request->get('search');
        $perPage    = $request->get('perPage');
        $order      = $request->get('sort') ?? 'name';
        $direction  = $request->get('direction') ?? 'asc';
        
        $customers = [];
        
        if (!empty($keyword)) 
        {
            $neighborhoods = Neighborhood::whereHas("town", function($q) use ($keyword){
                    $q->where('name', 'LIKE', "%$keyword%");
                })
                ->orWhere('name','like','%'.$keyword.'%')
                ->with(['town'])
                ->orderBy($order, $direction)
                ->latest()->paginate($perPage);
        }
        else
        {
            $neighborhoods = Neighborhood::orderBy($order, $direction)
                ->latest()->paginate($perPage);
        }

        return view($this->path . '.index',compact('neighborhoods', 'keyword', 'perPage', 'order','direction'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->path.'.create')
                ->with('towns', $this->towns);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NeighborhoodValidator $request)
    {
        try {
            $neighborhood = new Neighborhood($request->all());
            $neighborhood->save();
            session()->put('success', 'Barrio registrado');
        } catch (\Exception $e) {
            session()->put('warning','Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Neighborhood  $neighborhood
     * @return \Illuminate\Http\Response
     */
    public function show(Neighborhood $neighborhood)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Neighborhood  $neighborhood
     * @return \Illuminate\Http\Response
     */
    public function edit(Neighborhood $neighborhood)
    {
        return view($this->path.'.edit')
                ->with('neighborhood', $neighborhood)
                ->with('towns', $this->towns);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Neighborhood  $neighborhood
     * @return \Illuminate\Http\Response
     */
    public function update(NeighborhoodValidator $request, Neighborhood $neighborhood)
    {
        try {
            $neighborhood->fill($request->all());
            $neighborhood->save();
            session()->put('success', 'Barrio actualizado');
        } catch (\Exception $e) {
            session()->put('warning','Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Neighborhood  $neighborhood
     * @return \Illuminate\Http\Response
     */
    public function destroy(Neighborhood $neighborhood)
    {
        try {
            $neighborhood->delete();
            session()->put('success', 'Barrio eliminado');
        } catch (\Exception $e) {
            session()->put('warning','Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Neighborhood  $neighborhood
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        try{
            Neighborhood::withTrashed()->find($id)->restore();
            session()->put('success','Barrio restaurado');
        } catch (Exception $e){
            session()->put('error','Se ha producido un error');
        } finally {            
            return redirect()->route($this->path.'.index');
        }
    }
}
