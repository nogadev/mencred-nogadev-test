<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Country;
use App\Models\Seller;
use App\Models\Commerce;
use App\Models\Kinship;
use App\Models\Province;
use App\Models\Route;
use App\Models\Neighborhood;
use App\Models\District;
use App\Models\Town;
use App\Models\CustomerCategory;
use App\Models\VisitDay;

use DB;

use Illuminate\Http\Request;
use App\Http\Requests\CustomerValidator;

class CustomerController extends Controller
{
    private $path = 'customers';
    private $countries;

    public function __construct(){
        $this->countries    = Country::all();
        $this->sellers      = Seller::orderBy('name')->get();
        $this->commerces    = Commerce::all();
        $this->kinships     = Kinship::all();
        $this->provinces    = Province::all();
        $this->routes       = Route::orderBy('name')->get();
        $this->neighborhoods= Neighborhood::all();
        $this->districts    = District::all();
        $this->towns        = Town::all();
        $this->customercategories = CustomerCategory::all();
        $this->visitdays    = VisitDay::All();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customers = [];
        $customers = Customer::with(['route','seller','commercial_town','commercial_neighborhood'])->orderBy('name')->get();
        return view($this->path . '.index',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->path.'.create')
            ->with('sellers', $this->sellers)
            ->with('routes', $this->routes)
            ->with('commerces', $this->commerces)
            ->with('districts', $this->districts)
            ->with('towns', $this->towns)
            ->with('kinships', $this->kinships)
            ->with('neighborhoods', $this->neighborhoods)
            ->with('customercategories',$this->customercategories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerValidator $request)
    {
        try {

            $request->merge([
                'antiquity'   => date_create_from_format('d/m/Y', $request->antiquity)->format('Y-m-d'),
                'birthday'   => date_create_from_format('d/m/Y', $request->birthday)->format('Y-m-d'),
            ]);

            $customer = new Customer($request->all());
            $customer->save();

            return response()->json([
                    'message' => 'Cliente creado con éxito',
                    'status' => 200
                ], 200);
        } catch (\Exception $e) {
            return response()->json([
                    'message' => $e->getMessage(),
                    'status' => 400
                ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {

        return view($this->path.'.edit')
            ->with('customer', $customer)
            ->with('sellers', $this->sellers)
            ->with('routes', $this->routes)
            ->with('commerces', $this->commerces)
            ->with('districts', $this->districts)
            ->with('towns', $this->towns)
            ->with('kinships', $this->kinships)
            ->with('neighborhoods', $this->neighborhoods)
            ->with('customercategories',$this->customercategories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerValidator $request, Customer $customer)
    {
        try {

            if(!isset($request->owner)) $request->merge(['owner' => 0]);
            if(!isset($request->defaulter)) $request->merge(['defaulter' => 0]);

            $request->merge([
                'birthday'   => date_create_from_format('d/m/Y', $request->birthday)->format('Y-m-d'),
                'antiquity'   => date_create_from_format('d/m/Y', $request->antiquity)->format('Y-m-d')
                ]);

            $customer->fill($request->all());
            $customer->update();

            return response()->json([
                    'message' => 'Cliente actualizado con éxito',
                    'status' => 200
                ], 200);
        } catch (\Exception $e) {
            return response()->json([
                    'message' => $e->getMessage(),
                    'status' => 400
                ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        try{
            Customer::withTrashed()->find($id)->restore();
            //session()->put('success','Cliente restaurado');
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
        $customer = Customer::with(['route','seller'])->find($request->id);
        return \Response::json($customer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fastStore(CustomerValidator $request)
    {
        try {
            $customer = new Customer($request->all());
            $customer->save();
        } catch (\Exception $e) {
            dd($e);
        }
        return \Response::json($customer);
    }

    /**
     * Orden de secuencia
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function sequence(Request $request)
    {
        $pathSequence = 'customers.sequence';
        Customer::doesnthave('activeCredits')
            ->update(['sequence_order' => 0]);

        return view($pathSequence.'.sequence')
            ->with('routes'     , $this->routes)
            ->with('visitdays'  , $this->visitdays);
    }

    public function getSequence(Request $request)
    {
        $route_id = $request->get('route_id');

        $sequence = Customer::where('route_id', '=', $route_id)
                        ->has('activeCredits')
                        ->with(['seller','commercial_neighborhood', 'visitday'])
                        ->orderBy('sequence_order')
                        ->get();

        return \Response::json($sequence);
    }

    public function storeSequence(Request $request)
    {
        try {
            DB::beginTransaction();

            if ( isset ( $request->sequence_data ) )
            {
                $sequence = json_decode($request->sequence_data);

                usort($sequence, function($a, $b)
                {
                    return $a->sequence_order == $b->sequence_order ?
                            ($a->old_sequence <> $a->sequence_order ? -1 : 1)
                                : ($a->sequence_order > $b->sequence_order ? 1
                                    : ($a->sequence_order < $b->sequence_order ? -1 : null)
                                );
                });

                $nextSequence = 1;
                foreach($sequence as $dat)
                {
                    $customer = Customer::find($dat->customer_id);
                    if($dat->sequence_order == 0
                        && ($customer->sequence_order <> $dat->sequence_order
                            || $customer->visitday_id <> $dat->visitday_id))
                    {
                        $customer->visitday_id    = $dat->visitday_id;
                        $customer->sequence_order = $dat->sequence_order;
                        $customer->save();
                    }
                    else
                    {
                        $customer->sequence_order = $nextSequence;

                        if($customer->sequence_order <> $dat->old_sequence
                            || $customer->visitday_id <> $dat->visitday_id)
                        {
                            $customer->visitday_id = $dat->visitday_id;
                            $customer->save();
                        }
                        $nextSequence++;
                    }
                }
            }

            DB::commit();
            return response()->json([
                    'message' => 'Orden de secuencia modificado con éxito',
                    'status' => 200
                ], 200);

        } catch (Exception $e) {
            DB::Rollback();
            return response()
                ->json([
                    'message' => $e->getMessage(),
                    'status' => 400
                ], 400);
        }
    }
}
