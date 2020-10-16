<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Province;
use App\Http\Requests\DistrictValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistrictController extends Controller
{
    private $path = 'districts';
    private $provinces;

    public function __construct(){
        $this->provinces = Province::orderBy('country_id')->orderBy('name')->get();;
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
            $districts = District::whereHas("province", function($q) use ($keyword){
                    $q->where('name', 'LIKE', "%$keyword%");
                })
                ->orWhere('name','like','%'.$keyword.'%')
                ->with(['province'])
                ->orderBy($order, $direction)
                ->latest()->paginate($perPage);
        }
        else
        {
            $districts = District::orderBy($order, $direction)
                ->with(['province'])
                ->latest()->paginate($perPage);
        }

        return view($this->path . '.index',compact('districts', 'keyword', 'perPage', 'order','direction'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->path.'.create')->with('provinces', $this->provinces);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DistrictValidator $request)
    {
        try {
            $district = new District($request->all());
            $district->save();
            session()->put('success','Departamento registrado');
        } catch (\Exception $e) {
            session()->put('warning','Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\District  $district
     * @return \Illuminate\Http\Response
     */
    public function show(District $district)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\District  $district
     * @return \Illuminate\Http\Response
     */
    public function edit(District $district)
    {
        return view($this->path.'.edit')
                ->with('district', $district)
                ->with('provinces', $this->provinces);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\District  $district
     * @return \Illuminate\Http\Response
     */
    public function update(DistrictValidator $request, District $district)
    {
        try {
            $district->fill($request->all());
            $district->save();
            session()->put('success','Departamento actualizado');
        } catch (\Exception $e) {
            session()->put('warning','Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\District  $district
     * @return \Illuminate\Http\Response
     */
    public function destroy(District $district)
    {
        try {
            $district->delete();
            session()->put('success','Departamento eliminado');
        } catch (\Exception $e) {
            session()->put('warning','Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\District  $district
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        try{
            District::withTrashed()->find($id)->restore();
            session()->put('success','Departamento restaurado');
        } catch (Exception $e){
            session()->put('error','Se ha producido un error');
        } finally {            
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Return a list of Towns in a District.
     *
     * @return \Illuminate\Http\Response
     */
    public function townsAjax(Request $request){
        $towns = DB::table("towns")->where("district_id",$request->id)->pluck("name","id");
        return json_encode($towns);
    }
}
