<?php
namespace App\Http\Controllers\API;


use App\Http\Controllers\BuyController;
use App\Http\Controllers\Controller;
use App\Traits\DataTrait;
use Illuminate\Http\Request;
use App\Traits\RestClientTrait;

class BoughtController extends Controller
{
    use RestClientTrait;
    use DataTrait;

    protected function getReportBought(Request $request)
    {
        $fileName = "Compras-" . date('yymd-h_m') . ".pdf";
        $dateInit =  $this->formatDate($request->date_init);
        $dateEnd = $this->formatDate($request->date_end);
        $supplierId = $request->supplier_id;
        $data = BuyController::getBoughtReportData($dateInit, $dateEnd, $supplierId);

        if (isset($data)) {
            $this->post('bought-articles', $data, $fileName);
        }
    }
}
