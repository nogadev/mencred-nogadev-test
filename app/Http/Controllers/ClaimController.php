<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Claim;
use App\Models\ClaimTraking;
use App\Models\Status;

class ClaimController extends Controller
{
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->merge([
            'init_date' => date_create_from_format('d/m/Y', $request->init_date)->format('Y-m-d'),
            'status_id' => Claim::STATUS['PENDIENTE']
        ]);
        $claim = NEW Claim($request->all());

        $claim->save();
        $claim->claimtrakings()->save(NEW ClaimTraking([
            'date_of'       => $request->init_date,
            'observation'   => $request->observation,
            'user_id'       => Auth()->User()->id
        ]));

        return response()->json($claim->load('status')->load('claimtrakings'));
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function json(Request $request)
    {

        $claims = [];
        if(!is_null($request->input('credit_id')))
        {
            $claims = Claim::where('credit_id', '=', $request->input('credit_id'))
                        ->with(['status','claimtrakings'])
                        ->orderBy('init_date')
                        ->get();
            ;
        }
        return response()->json($claims);
    }

    //API

    public function findByCredit_json($creditId = null) {
        $claim = Claim::where('credit_id', '=', $creditId)
                  ->with(['credit','status'])
                  ->get();
                  
        return response()->json($claim);
    }

    public function resolv(Request $request)
    {
        $claim = Claim::find($request->id);
        $claim->end_date  = time();
        $claim->status_id = 8;

        $claim->update();

        return response()->json($claim);
    }

    public function trakingStore(Request $request)
    {
        $claimTraking = NEW ClaimTraking($request->all());
        $claimTraking->user_id = Auth()->User()->id;

        $claimTraking->save();
        return response()->json($claimTraking);
    }

    public function showClaimsReport()
    {
        $pathClaims = 'reports.claims.claims';
        $statuses = Status::whereIn('id',[7,8])->get();
    	return view($pathClaims, compact('statuses'));
    }

    public function getClaimsByStatus(Request $request)
    {
        $status_id = $request->status_id ?: null;
        
        $data = Claim::when($status_id, function($q) use ($status_id){
                $q->where('claims.status_id','=',$status_id);
            })
            ->select(['status.status','claims.type','customers.name as customer','customers.contact_tel','customers.comercial_tel','customers.particular_tel','routes.name as route','sellers.name as seller','credits.id'])
            ->join('credits','credits.id','=','claims.credit_id')
            ->join('customers','customers.id','=','credits.customer_id')
            ->join('sellers','customers.seller_id','=', 'sellers.id')
            ->join('routes','customers.route_id','=', 'routes.id')
            ->join('status','credits.status_id','=', 'status.id')
            ->orderBy('claims.id','desc')
            ->get();

        //die($data);
        return response()->json($data, 200);
    }


}
