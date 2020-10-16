<?php

namespace App\Http\Controllers;

use App\Models\ArticleCategory;
use App\Http\Requests\ArticleCategoryValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleCategoryController extends Controller
{
    private $path = 'articleCategories';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articleCategories = ArticleCategory::withTrashed()->get();
        return view($this->path.'.index', compact('articleCategories'));
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
    public function store(ArticleCategoryValidator $request)
    {
        try{
            $articleCategory = new ArticleCategory($request->all());
            $articleCategory->save();
            session()->put('success','Categoria guardada');
        } catch (\Exception $e) {
            session()->put('warning','Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ArticleCategory  $articleCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ArticleCategory $articleCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ArticleCategory  $articleCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ArticleCategory $articleCategory)
    {
        return view($this->path.'.edit', compact('articleCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ArticleCategory  $articleCategory
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleCategoryValidator $request, ArticleCategory $articleCategory)
    {
        try{
            $articleCategory->fill($request->all());
            $articleCategory->save();
            session()->put('success','Categoria modificada');
        } catch (\Exception $e) {
            session()->put('warning','Se ha producido un error');
        } finally {
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ArticleCategory  $articleCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ArticleCategory $articleCategory)
    {
        try{
            $articleCategory->delete();
            session()->put('success','Categoria eliminada');
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
            ArticleCategory::withTrashed()->find($id)->restore();
            session()->put('success','Categoria restaurada');
        } catch (Exception $e){
            session()->put('error','Se ha producido un error');
        } finally {            
            return redirect()->route($this->path.'.index');
        }
    }

    /**
     * Return a list of Attributes in an Article
     *
     * @return \Illuminate\Http\Response
     */
    public function attributesAjax(Request $request){
        $attributes = DB::table("attributes")->where("article_category_id",$request->id)->pluck("name","id");
        return json_encode($attributes);
    }
}
