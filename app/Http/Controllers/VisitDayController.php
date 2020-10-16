<?php

namespace App\Http\Controllers;

use App\Models\VisitDay;
use App\Http\Requests\VisitDayValidator;
use Illuminate\Http\Request;

class VisitDayController extends Controller
{
    private $path = 'visitDays';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visitDays = VisitDay::withTrashed()->get();
        return view($this->path.'.index', compact('visitDays'));
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
    public function store(Request $request)
    {
        try{
            $visitDay = new VisitDay($request->all());
            $visitDay->save();
            session()->put('success','Dia de visita guardado');
        } catch (\Exception $e) {
            session()->put('warning','Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VisitDay  $visitDay
     * @return \Illuminate\Http\Response
     */
    public function show(VisitDay $visitDay)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VisitDay  $visitDay
     * @return \Illuminate\Http\Response
     */
    public function edit(VisitDay $visitDay)
    {
        return view($this->path.'.edit', compact('visitDay'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VisitDay  $visitDay
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VisitDay $visitDay)
    {
        try{
            $visitDay->fill($request->all());
            $visitDay->save();
            session()->put('success','Dia de visita modificado');
        } catch (\Exception $e) {
            session()->put('warning','Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VisitDay  $visitDay
     * @return \Illuminate\Http\Response
     */
    public function destroy(VisitDay $visitDay)
    {
        try{
            $visitDay->delete();
            session()->put('success','Dia de visita eliminado');
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
            VisitDay::withTrashed()->find($id)->restore();
            session()->put('success','Dia de visita restaurado');
        } catch (Exception $e){
            session()->put('error','Se ha producido un error');
        } finally {            
            return redirect()->route($this->path.'.index');
        }
    }
}
