<?php

use Illuminate\Http\Request;

use App\Models\Article;
use App\Models\ArticlePrice;
use App\Models\ArticleStock;
use App\Models\Cash;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//ESTO ES LA PARTE VIEJA QUE HIZO EL NINJA. LO VAMOS A REVISAR 
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('articles', function (){
    return datatables()
            ->eloquent(Article::withTrashed())
            ->addColumn('actions', 'articles.actions')
            ->addColumn('state', function (Article $article){
                switch ($article->state) {
                    case 'A':
                        return 'ACTIVO';
                        break;
                    case 'D':
                        return 'DISCONTINUADO';
                        break;
                }
            })
            ->rawColumns(['actions'])
            ->toJson();
});

Route::get('prices.articles', function (){
    return datatables()
            ->eloquent(Article::query()->where('available','=',1))
            ->addColumn('actions', 'prices.actions')
            ->rawColumns(['actions'])
            ->toJson();
});


Route::get('stock.articles', function (Request $request){
    return datatables()
            ->eloquent(ArticleStock::with('article:id,description')
                ->whereStoreId($request->store_id)
                ->whereCompanyId($request->company_id)
            )
            ->addColumn('actions', 'stocks.actions')
            ->rawColumns(['actions'])
            ->toJson();
            
});


Route::post('stock.articles', function (Request $request){
    return datatables()
            ->eloquent(ArticleStock::with('article:id,description')
                ->whereStoreId($request->store_id)
                ->whereCompanyId($request->company_id)
            )
            ->addColumn('actions', 'stocks.actions')
            ->rawColumns(['actions'])
            ->toJson();
            
});

Route::get('cashes', function (){
    return datatables()
            ->eloquent(Cash::withTrashed())
            ->addColumn('actions', 'cashes.actions')
            ->rawColumns(['actions'])
            ->toJson();
});