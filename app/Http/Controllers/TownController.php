<?php

namespace App\Http\Controllers;

use App\Models\Town;
use App\Models\District;
use Illuminate\Http\Request;
use App\Http\Requests\TownValidator;
use Illuminate\Support\Facades\DB;

class TownController extends Controller
{
    private $path = "towns";
    private $districts;

    public function __construct(){
        $this->districts = District::orderBy('province_id')->orderBy('name')->get();
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
            $tows = Town::whereHas("district", function($q) use ($keyword){
                    $q->where('name', 'LIKE', "%$keyword%");
                })
                ->orWhere('name','like','%'.$keyword.'%')
                ->with(['district'])
                ->orderBy($order, $direction)
                ->latest()->paginate($perPage);
        }
        else
        {
            $towns = Town::orderBy($order, $direction)
                ->with(['district'])
                ->latest()->paginate($perPage);
        }

        return view($this->path . '.index',compact('towns', 'keyword', 'perPage', 'order','direction'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->path.'.create')
                ->with('districts', $this->districts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TownValidator $request)
    {
        try {
            $town = new Town($request->all());
            $town->save();
            session()->put('success', 'Localidad registrada');
        } catch (\Exception $e) {
            session()->put('warning','Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Town  $town
     * @return \Illuminate\Http\Response
     */
    public function show(Town $town)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Town  $town
     * @return \Illuminate\Http\Response
     */
    public function edit(Town $town)
    {
        return view($this->path.'.edit')
                ->with('town', $town)
                ->with('districts', $this->districts);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Town  $town
     * @return \Illuminate\Http\Response
     */
    public function update(TownValidator $request, Town $town)
    {
        try {
            $town->fill($request->all());
            $town->save();
            session()->put('success', 'Localidad actualizada');
        } catch (\Exception $e) {
            session()->put('warning','Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Town  $town
     * @return \Illuminate\Http\Response
     */
    public function destroy(Town $town)
    {
        try {
            $town->delete();
            session()->put('success', 'Localidad eliminada');
        } catch (\Throwable $th) {
            session()->put('warning','Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Town  $town
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        try{
            Town::withTrashed()->find($id)->restore();
            session()->put('success','Localidad restaurada');
        } catch (Exception $e){
            session()->put('error','Se ha producido un error');
        } finally {            
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Return a list of Neighborhoods in a Town.
     *
     * @return \Illuminate\Http\Response
     */
    public function neighborhoodsAjax(Request $request){
        $neighborhoods = DB::table("neighborhoods")->where("town_id",$request->id)->pluck("name","id");
        return json_encode($neighborhoods);
    }
}
