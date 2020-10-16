<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Requests\ProvinceValidator;
use Illuminate\Support\Facades\DB;

class ProvinceController extends Controller
{
    private $path = "provinces";   
    private $countries;

    public function __construct(){
        $this->countries = Country::orderBy('name')->get();
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
        
        $provinces = [];
        
        if (!empty($keyword)) 
        {
            $provinces = Province::whereHas("country", function($q) use ($keyword){
                    $q->where('name', 'LIKE', "%$keyword%");
                })
                ->orWhere('name','like','%'.$keyword.'%')
                ->with(['country'])
                ->orderBy($order, $direction)
                ->latest()->paginate($perPage);
        }
        else
        {
            $provinces = Province::orderBy($order, $direction)
                ->with(['country'])
                ->latest()->paginate($perPage);
        }

        return view($this->path . '.index',compact('provinces', 'keyword', 'perPage', 'order','direction'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->path.'.create')
                ->with('countries', $this->countries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProvinceValidator $request)
    {
        try{
            $province = new Province($request->all());
            $province->save();
            session()->put('success','Provincia registrada');
        } catch (\Exception $e) {
            session()->put('warning','Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Province  $province
     * @return \Illuminate\Http\Response
     */
    public function show(Province $province)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Province  $province
     * @return \Illuminate\Http\Response
     */
    public function edit(Province $province)
    {
        return view($this->path.'.edit')
                ->with('countries', $this->countries)
                ->with('province', $province);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Province  $province
     * @return \Illuminate\Http\Response
     */
    public function update(ProvinceValidator $request, Province $province)
    {
        try {
            $province->fill($request->all());
            $province->save();
            session()->put('success','Provincia actualizada');
        } catch (\Exception $e) {
            session()->put('warning','Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Province  $province
     * @return \Illuminate\Http\Response
     */
    public function destroy(Province $province)
    {
        try {
            $province->delete();
            session()->put('success','Provincia eliminada');
        } catch (\Exception $e) {
            session()->put('warning','Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Province  $province
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        try{
            Province::withTrashed()->find($id)->restore();
            session()->put('success','Provincia restaurada');
        } catch (Exception $e){
            session()->put('error','Se ha producido un error');
        } finally {            
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Return a list of Districts in a Province.
     *
     * @return \Illuminate\Http\Response
     */
    public function districtsAjax(Request $request){
        $districts = DB::table("districts")->where("province_id",$request->id)->pluck("name","id");
        return json_encode($districts);
    }
}
