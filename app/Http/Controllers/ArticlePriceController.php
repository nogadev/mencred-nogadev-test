<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticlePrice;
use App\Http\Requests\ArticlePriceValidator;
use Illuminate\Http\Request;

class ArticlePriceController extends Controller
{

    public function store(ArticlePriceValidator $request)
    {
        try {

            $article = Article::find($request->article_id);
            $article->price_update_level = $request->price_update_level;
            $article->save();

            $articlePrice = ArticlePrice::firstOrNew(array(
                'article_id' => $request->article_id,
                'point_of_sales_id' =>$request->point_of_sales_id));

            $articlePrice->article_id = $request->article_id;
            $articlePrice->point_of_sales_id = $request->point_of_sales_id;
            $articlePrice->price = $request->price;
            $articlePrice->fee_amount = $request->fee_amount;
            $articlePrice->fee_quantity = $request->fee_quantity;
            $articlePrice->save();

            return \Response::json($articlePrice);
        } catch (\Exception $e) {
            return \Response::json('msg', 'Se ha producido un error');
        }
    }

    public function findByArticle(Request $request){

        $article_id = $request->get('article_id');

        $prices = ArticlePrice::with(['point_of_sales'])
            ->where('article_id', '=', $article_id)
            ->get();

        return \Response::json($prices);
    }

    public function findByPriceByPointOfSale(Request $request){

        $article_id = $request->get('article_id');
        $point_of_sale_id = $request->get('point_of_sale_id');

        $prices = ArticlePrice::with(['point_of_sales'])
            ->where('article_id', '=', $article_id)
            ->where('point_of_sales_id', '=', $point_of_sale_id)
            ->get();

        return \Response::json($prices);
    }

    public function destroy(Request $request)
    {
        try {
            $articlePrice = ArticlePrice::find($request->id);
            $articlePrice->delete();
            return \Response::json('code', 200);
        } catch (\Exception $e) {
            return \Response::json('code', 404);
        }
    }

}