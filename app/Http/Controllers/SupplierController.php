<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Country;
use App\Models\Province;
use App\Models\District;
use App\Models\Town;
use App\Models\Neighborhood;
use App\Models\Traveler;
use Illuminate\Http\Request;
use App\Http\Requests\SupplierValidator;

class SupplierController extends Controller
{
    private $path = 'suppliers';
    private $countries;
    private $provinces;
    private $districts;
    private $towns;
    private $neighborhood;

    public function __construct(){
        $this->countries    = Country::all();
        $this->travelers    = Traveler::all();
        $this->provinces    = Province::all();
        $this->districts    = District::all();
        $this->towns        = Town::all();
        $this->neighborhoods= Neighborhood::all();

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::withTrashed()->get();
        return view($this->path.'.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->path.'.create')
                ->with('countries', $this->countries)
                ->with('provinces', $this->provinces)
                ->with('neighborhoods', $this->neighborhoods)
                ->with('towns', $this->towns)
                ->with('districts',$this->districts)
                ->with('travelers', $this->travelers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierValidator $request)
    {
        try {
            $supplier = new Supplier($request->all());
            $supplier->save();
            session()->put('success', 'Proveedor registrado');
        } catch (\Exception $e) {
            session()->put('warning', 'Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        $provinces      = Province::where('country_id','=',$supplier->province_id)->get();
        $districts      = District::where('province_id','=',$supplier->province_id)->get();
        $towns          = Town::where('district_id','=',$supplier->district_id)->get();
        $neighborhoods  = Neighborhood::where('town_id','=',$supplier->town_id)->get();

        return view($this->path.'.edit')
                ->with('supplier', $supplier)
                ->with('countries', $this->countries)
                ->with('provinces', $provinces)
                ->with('districts', $districts)
                ->with('towns', $towns)
                ->with('neighborhoods', $neighborhoods)
                ->with('travelers', $this->travelers);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierValidator $request, Supplier $supplier)
    {
        try {
            $supplier->fill($request->all());
            $supplier->save();
            session()->put('success', 'Proveedor modificado');
        } catch (\Exception $e) {
            session()->put('warning', 'Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        //
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        try{
            Supplier::withTrashed()->find($id)->restore();
            session()->put('success','Proveedor restaurado');
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
     * @return \App\Models\Supplier
     */
    public function getById(Request $request){
        $supplier = Supplier::find($request->id);
        return \Response::json($supplier);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fastStore(SupplierValidator $request)
    {
        try {
            $supplier = new Supplier($request->all());
            $supplier->save();
        } catch (\Exception $e) {
            // TODO with errors
        }
        return \Response::json($supplier);
    }
}
