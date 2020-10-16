<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Http\Requests\CompanyValidator;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    private $path = 'companies';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::withTrashed()->get();
        return view($this->path.'.index', compact('companies'));
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
    public function store(CompanyValidator $request)
    {
        try {
            $company = new Company($request->all());
            $company->save();
            session()->put('success', 'Empresa registrada');
        } catch (\Exception $e) {
            session()->put('warning', 'Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view($this->path.'.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyValidator $request, Company $company)
    {
        try {
            $company->fill($request->all());
            $company->save();
            session()->put('success', 'Empresa actualizada');
        } catch (\Exception $e) {
            session()->put('warning', 'Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        try {
            $company->delete();
            session()->put('success', 'Empresa eliminada');
        } catch (\Exception $e) {
            session()->put('warning', 'Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        try {
            Company::withTrashed()->find($id)->restore();
            session()->put('success', 'Empresa restaurada');
        } catch (\Exception $e) {
            session()->put('warning', 'Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fastStore(CompanyValidator $request)
    {
        try {
            $company = new Company($request->all());
            $company->save();
        } catch (\Exception $e) {
            // TODO with errors
        }
        return \Response::json($company);
    }
}
