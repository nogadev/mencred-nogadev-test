<?php

namespace App\Listeners;

use App\Events\StockMovement;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\ArticleStock;

class SetArticleStock
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  StockMovement  $event
     * @return void
     */
    public function handle(StockMovement $event)
    {        
        $articleStock = ArticleStock::where([
            ["article_id",$event->stock->article->id],
            ["store_id",$event->stock->store->id],
            ["company_id", $event->stock->company->id]
        ])->first();

        if ($articleStock == null) {
            $articleStock = new ArticleStock();
            $articleStock->article_id = $event->stock->article->id;
            $articleStock->store_id = $event->stock->store->id;
            $ArticleStock->company_id = $event->stock->company->id;
            $articleStock->price = 0.00;
            $articleStock->fee_quantity = 0;
            $articleStock->fee_ammount = 0.00;
        }
        
        if ($event->stock->in_out == 'I') {
            $articleStock->stock += $event->stock->quantity;
        } else {
            $articleStock->stock -= $event->stock->quantity;
        }
        $articleStock->save();
    }
}
