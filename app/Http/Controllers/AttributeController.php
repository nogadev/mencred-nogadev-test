<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\ArticleCategory;
use App\Http\Requests\AttributeValidator;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    private $path = 'attributes';
    private $articleCategories;

    public function __construct(){
        $this->articleCategories = ArticleCategory::all();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attributes = Attribute::withTrashed()->get();
        return view($this->path.'.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->path.'.create')
                ->with('articleCategories', $this->articleCategories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttributeValidator $request)
    {
        try {
            $attribute = new Attribute($request->all());
            $attribute->save();
            return response()->json([
                'message' => 'Atributo registrado',
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
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function show(Attribute $attribute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function edit(Attribute $attribute)
    {
        return view($this->path.'.edit')
                ->with('attribute', $attribute)
                ->with('articleCategories', $this->articleCategories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function update(AttributeValidator $request, Attribute $attribute)
    {
        try {
            $attribute->fill($request->all());
            $attribute->save();
            session()->put('success', 'Atributo actualizado');
        } catch (\Exception $e) {
            session()->put('warning', 'Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attribute $attribute)
    {
        try {
            $attribute->delete();
            session()->put('success', 'Atributo eliminado');
        } catch (\Exception $e) {
            session()->put('warning', 'Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attribute  $attribute
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        try {
            Attribute::withTrashed()->find($id)->restore();
            session()->put('success', 'Atributo restaurado');
        } catch (\Exception $e) {
            session()->put('warning', 'Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }
}
