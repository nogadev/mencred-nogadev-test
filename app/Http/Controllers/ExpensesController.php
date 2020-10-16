<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\ExpenseConcept;
use App\Models\Seller;
use App\Models\Cash;

use App\Http\Controllers\CashController;

class ExpensesController extends Controller
{

    private $path = 'expenses';

    public function __construct()
    {
        $this->sellers  = Seller::all();
        $this->concepts = ExpenseConcept::all();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $expenses = Expense::orderBy('id','desc')->limit(10)->get();

        return view($this->path.'.create')
            ->with('sellers', $this->sellers)
            ->with('concepts', $this->concepts)
            ->with('expenses', $expenses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->merge([
            'amount'        => str_replace(['$','.',','], ['','','.'], $request->amount),
            'date'  => date_create_from_format('d/m/Y', $request->date)->format('Y-m-d'),
        ]);
        
        //guardamos el gasto
        $gasto = NEW Expense((array)$request->all());
        $ret = $gasto->save();

        $concept=$request->expenseconcept_id;
        $subtract = ExpenseConcept::Where('id',$concept)
                ->select('subtract')
                ->get();
        /*
        //guardamos el movimiento en la caja
        $cash = Cash::where('date_of', '=', date('Y-m-d'))->first();
        if(is_null($cash))
        {
            $cash = CashController::openCash();
        }

        $mv = NEW CashMovement([
            'cash_id'           => $cash->id,
            'movementreason_id' => 2003, //hardcode
            'movementtype_id'   => 1, //ingreso hardcode
            'amount'            => $total,
            'description'       => 'RENDICION ' . $route->name,
            'reference'         => $route->name,
            'method'            => 'RENDICION COBRADOR',
        ]);
        $cash->movements()->save($mv);
        */
        return response()->json(array('gasto'=>$gasto,'subtract'=>$subtract[0]->subtract));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
