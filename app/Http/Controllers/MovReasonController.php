<?php

namespace App\Http\Controllers;

use App\Models\MovReason;
use App\Models\MovType;
use Illuminate\Http\Request;
use App\Http\Requests\MovReasonValidator;

class MovReasonController extends Controller
{
    private $path = 'movreasons';
    private $mov_types;

    public function __construct() {
        $this->mov_types    = MovType::all();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mov_reasons = MovReason::with('mov_types')->where('available','=',true)->get();
        return view($this->path.'.index')->with('mov_reasons',$mov_reasons);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->path.'.create')
            ->with('mov_types', $this->mov_types);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MovReasonValidator $request)
    {
        try {
            $mov_reason = new MovReason($request->all());
            $mov_reason->save();
            session()->put('success', 'Motivo registrado');
        } catch (\Exception $e) {
            session()->put('warning', 'Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }


    public function edit($reason)
    {
        $mov_reason = MovReason::find($reason);
        return view($this->path.'.edit')
            ->with('mov_reason', $mov_reason)
            ->with('mov_types', $this->mov_types);
    }


    public function update(MovReasonValidator $request)
    {
        try {
            $movReason = MovReason::find($request->id);
            $movReason->fill($request->all());
            $movReason->update();
            session()->put('success', 'Motivo modificado');
        } catch (\Exception $e) {
            die(json_encode($e));
            session()->put('warning', 'Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }
}
