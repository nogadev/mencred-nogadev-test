<?php

namespace App\Http\Controllers;

use App\Models\MovReason;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Requests\CreditValidator;

use Auth;
use DB;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Store;
use App\Models\Article;
use App\Models\Tax;
use App\Models\Seller;
use App\Models\Delivery;
use App\Models\Credit;
use App\Models\Status;
use App\Models\Route;
use App\Models\Reason;
use App\Models\Fee;
use App\Models\Cash;
use App\Models\CashMov;
use App\Models\PaymentDetail;
use App\Models\PointOfSale;
use App\Models\Bank;

use App\Http\Controllers\CashController;


class CreditController extends Controller
{
    private $path = 'credits';
    private $companies;
    private $customers;
    private $voucherTypes;
    private $articles;
    private $taxes;
    private $stores;
    private $deliveries;
    private $sellers;
    private $status;
    private $routes;
    private $reasons;
    private $pointOfSale;
    private $banks;

    public function __construct()
    {
        $this->companies = Company::all();
        $this->customers = Customer::all();
        $this->sellers = Seller::all();
        $this->deliveries = Delivery::all();
        $this->articles = Article::all();
        $this->taxes = Tax::all();
        $this->stores = Store::all();
        $this->status = Status::all();
        $this->routes = Route::all();
        $this->reasons = Reason::all();
        $this->pointOfSale = PointOfSale::all();
        $this->banks = Bank::all();
    }

    public function currency_format($currency)
    {
        return str_replace([' ','$','.',','], ['','','','.'], $currency);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $isOpenCash = CashController::validateCurrentCash();
        $keyword = $request->get('search');
        $perPage = ($request->get('perPage')===null)?"50":$request->get('perPage');
        $order = $request->get('sort') ?? 'id';
        $direction = $request->get('direction') ?? 'desc';
        $status_id = $request->get('status_id') ?? null;
        $route_id = $request->get('route_id') ?? null;

        $credits = [];

        $arr_where = [];
        if (!is_null($status_id)) {
            array_push($arr_where, ['status_id', '=', $status_id]);
        }


        if (!empty($keyword)) {
            $credits = Credit::whereHas("customer", function ($q) use ($keyword, $route_id) {
                $q->where('name', 'LIKE', "%$keyword%");
                !is_null($route_id) ? $q->where('route_id', '=', $route_id) : '';
            })
                ->where($arr_where)
                ->orWhere('id','=',"$keyword")
                ->with(['customer', 'seller', 'status', 'delivery', 'user'])
                ->orderBy($order, $direction)
                ->latest()->paginate($perPage);
        } else {
            $credits = Credit::whereHas("customer", function ($q) use ($route_id) {
                !is_null($route_id) ? $q->where('route_id', '=', $route_id) : '';
            })
                ->with(['customer', 'seller', 'status', 'delivery', 'user'])
                ->where($arr_where)
                ->orderBy($order, $direction)
                ->latest()->paginate($perPage);
        }
        $status = $this->status;
        $routes = $this->routes;

        return view($this->path . '.index',
            compact('status_id', 'route_id', 'credits', 'keyword', 'perPage', 'order', 'direction', 'status', 'routes'))
            ->with('isOpenCash', $isOpenCash);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $isOpenCash = CashController::validateCurrentCash();
        $path = "credits.create";
        return view($path . '.create')
            ->with('customers', $this->customers)
            ->with('sellers', $this->sellers)
            ->with('deliveries', $this->deliveries)
            ->with('voucherTypes', $this->voucherTypes)
            ->with('companies', $this->companies)
            ->with('articles', $this->articles)
            ->with('taxes', $this->taxes)
            ->with('stores', $this->stores)
            ->with('routes', $this->routes)
            ->with('pointOfSale', $this->pointOfSale)
            ->with('banks', $this->banks)
            ->with('isOpenCash', $isOpenCash);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreditValidator $request)
    {
        $request->merge([
            'paid_amount'        => floatval($this->currency_format($request->paid_amount)),
        ]);

        try {
            DB::beginTransaction();
            $request->merge([
                'created_date' => date_create_from_format('d/m/Y', $request->created_date)->format('Y-m-d'),
                'fee_amount' => floatval($this->currency_format($request->fee_amount)),
                'initial_payment' => floatval($this->currency_format($request->init_pay)),
                'total_amount' => floatval($this->currency_format($request->total_amount)),
                'a_subtotal'    => floatval($this->currency_format($request->a_subtotal)),
                'a_price'   => floatval($this->currency_format($request->a_price)),
            ]);

            $credit = new Credit($request->all());
            $credit->user_id = Auth::user()->id;
            if($credit->initial_payment>$credit->total_amount){
                DB::Rollback();
                return response()
                ->json([
                    'message' => 'Error en pago inicial',
                    'status' => 400
                ], 400);
            }else if($credit->initial_payment===$credit->total_amount&&$credit->fee_quantity!=='1'){
                DB::Rollback();
                return response()
                ->json([
                    'message' => 'Error en el numero de cuotas',
                    'status' => 400
                ], 400);
            }else{
                $credit->status_id = Status::A_CONFIRMAR;
            }

            $credit->save();

            if (isset($request->art_data)) {
                $array = json_decode($request->art_data);
                foreach ($array as $ca) {

                    $art = Article::find($ca->article_id);

                    $credit->articles()->save($art, [
                        'price' => $ca->price,
                        'quantity' => $ca->quantity,
                        'serial_number' => $ca->serie,
                        'company_id' => $ca->company_id,
                        'store_id' => $ca->store_id,
                        'point_of_sale_id' => $ca->point_of_sale_id
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                'message' => 'CREDITO CARGADO CORRECTAMENTE',
                'status' => 200
            ], 200);
        } catch (Exception $e) {
            DB::Rollback();
            return response()
                ->json([
                    'message' => $e->getMessage(),
                    'status' => 400
                ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\credit $credit
     * @return \Illuminate\Http\Response
     */
    public function show(credit $credit)
    {
        return view($this->path . '.show')
            ->with('credit', $credit);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\credit $credit
     * @return \Illuminate\Http\Response
     */
    public function edit(credit $credit)
    {
        return view($this->path . '.edit')
            ->with('credit', $credit)
            ->with('reasons', $this->reasons);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\credit $credit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, credit $credit)
    {
    }

    public function updateFee(Request $request)
    {
        $request->merge([
            'paid_amount'        => floatval(floatval($this->currency_format($request->paid_amount))),
        ]);
        $fee = Fee::find($request->id);
        if (!is_null($fee)) {
            $fee->fill($request->all());
            $fee->update();


            if (isset($fee->credit->totalPaid->paid_amount)) {
                if ($fee->credit->total_amount <= ($fee->credit->totalPaid->paid_amount + $fee->paid_amount)) {
                    $fee->credit->status_id = Status::PAGARE;
                    $fee->credit->save();
                }
            }

            return json_encode(true);
        } else {
            return json_encode(false);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\credit $credit
     * @return \Illuminate\Http\Response
     */
    public function destroy(credit $credit)
    {
        //
    }

    public function changeStatus(Request $request)
    {
        
        $id = $request->input('id');
        $status_id = $request->input('status_id');

        $credit = Credit::find($id);

        //Devolver stock si se rechaza el credito
        if ($credit->status_id == 2 && $status_id == 6) {
            foreach ($credit->articles as $article) {
                $articleStock = $article->articleStocks->where('company_id', '=', $article->pivot->company_id)
                    ->where('store_id', '=', $article->pivot->store_id)
                    ->first();
                $articleStock->stock = $articleStock->stock + $article->pivot->quantity;
                $articleStock->save();
            }
        }

        if ($status_id == 6 && $credit->initial_payment > 0) {
            CashMov::where('reference', $id)->delete();
        }

        if($credit->initial_payment===$credit->total_amount && $status_id != 6){
            $credit->status_id = Status::CONTADO;
        }else{
            $credit->status_id = $status_id;
        }

        if ($credit->status_id == Status::OPERANDO || $credit->status_id == Status::CONTADO) {
            $credit->init_date = date('Y-m-d', strtotime("+1 day"));
            $credit->confirm_date = date('Y-m-d');

            //Actualizamos stock al confirmar el credito
            foreach ($credit->articles as $article) {
                $articleStock = $article->articleStocks->where('company_id', '=', $article->pivot->company_id)
                    ->where('store_id', '=', $article->pivot->store_id)
                    ->first();
                $articleStock->stock = $articleStock->stock - $article->pivot->quantity;
                $articleStock->save();
            }

            //INIT PAID - FIRST FEE - Comento por ahora para testear esto
            //if ($credit->initial_payment > 0) {
                $fee = NEW Fee([
                    'route_id' => $credit->customer->route_id,
                    'number' => 1,
                    'paid_date' => date('Y-m-d'),
                    'payment_amount' => $credit->initial_payment,
                    'paid_amount' => $credit->initial_payment
                ]);
                $credit->fees()->save($fee);

                $cash = CashController::getCurrentCash();

                $mv = NEW CashMov([
                    'cash_id' => $cash->id,
                    'mov_reason_id' => 2,
                    'payment_method_id' => 1, //EFECTIVO
                    'amount' => $credit->initial_payment,
                    'description' => 'CUOTA INICIAL ' . $credit->customer->name,
                    'reference' => $credit->id
                ]);
                $cash->movements()->save($mv);
            //}
        }

        if ($credit->save()) {
            return json_encode($credit->status_id);
        } else {
            return json_encode(false);
        }
    }

    public function collect()
    {
        $isOpenCash = CashController::validateCurrentCash();
        return view($this->path . '.collection' . '.collect')
            ->with('routes', $this->routes)
            ->with('banks', $this->banks)
            ->with('reasons', $this->reasons)
            ->with('isOpenCash', $isOpenCash);
    }

    public function getCollect(Request $request)
    {
        $route_id = $request->get('route_id');
        $date = date('Y-m-d', strtotime(str_replace('/', '-', $request->date)));
        $credits = Credit::where('status_id', '=', Status::OPERANDO)
            ->where('init_date', '<=', $date)
            //->whereNull('guarantee')
            ->select(['credits.*', 'customers.name', 'customers.route_id'])
            ->with(['lastNumberFee'])
            ->join('customers', 'customers.id', '=', 'credits.customer_id')
            ->join('status', 'status.id', '=', 'credits.status_id')
            ->where('customers.route_id', '=', $route_id)
            ->orderBy(DB::RAW('status.status, customers.name , credits.id'))
            ->get();

        return \Response::json($credits);
    }

    public function storeCollect(Request $request)
    {
        try {
            DB::beginTransaction();

            if (isset($request->fee_data)) {
                $fees = json_decode($request->fee_data);
                $payment_method_id = $request->payment_method_id;

                $total = 0;
                $paycheck_total = 0;
                $mercadopago_total = 0;

                foreach ($fees as $fee_data) {

                    $total = $total + $fee_data->paid_amount;

                    $fee_data->paid_date = date_create_from_format('d/m/Y', $fee_data->paid_date ?? $request->created_date)->format('Y-m-d');

                    //CREDITO
                    $credit = Credit::find($fee_data->credit_id);


                    //NUEVA CUOTA
                    $fee = new Fee((array)$fee_data);

                    if (isset($credit->totalPaid->paid_amount)) {
                        //SI SE PAGA TODO, EL CREDITO PASA A PAGARE
                        if ($credit->total_amount <= ($credit->totalPaid->paid_amount + $fee->paid_amount)) {
                            $credit->status_id = Status::PAGARE;
                            $credit->save();
                        }
                    }


                    $fee->save();

                    if (isset($fee_data->paycheck)) {
                        $payment = [];
                        $payment['payment_date'] = date_create_from_format('d/m/Y', $fee_data->paycheck->paymentdate)->format('Y-m-d');
                        $payment['amount'] = $fee_data->paycheck->amount;
                        $payment['number'] = $fee_data->paycheck->number;
                        $payment['owner_name'] = $fee_data->paycheck->owner_name;
                        $payment['payment_method_id'] = PaymentMethod::CHEQUE;
                        $payment['status_id'] = 9;
                        $payment['bank_id'] =$fee_data->paycheck->bank;

                        $payment_detail = new PaymentDetail($payment);

                        $payment_detail->save();

                        $fee->payment_detail_id = $payment_detail->id;

                        $paycheck_total = $paycheck_total + $payment_detail->amount;

                        $fee->save();
                    }

                    if (isset($fee_data->mercadopago)) {
                        $payment = [];
                        $payment['payment_date'] = $fee_data->paid_date;
                        $payment['amount'] = $fee_data->mercadopago->amount;
                        $payment['number'] = $fee_data->mercadopago->number;
                        $payment['bank_id'] = Bank::MERCADOPAGO;
                        $payment['payment_method_id'] = PaymentMethod::MERCADOPAGO;
                        $payment['status_id'] = Status::CARTERA;

                        $payment_detail = new PaymentDetail($payment);

                        $payment_detail->save();

                        $fee->payment_detail_id = $payment_detail->id;

                        $mercadopago_total = $mercadopago_total + $payment_detail->amount;

                        $fee->save();
                    }
                }

                //GUARDAMOS EN CAJA ACTUAL
                $cash = CashController::getCurrentCash();

                $route = Route::find($request->route_id);

                $payment_method = PaymentMethod::find($payment_method_id);

                $total = $total - $paycheck_total - $mercadopago_total;

                $mv = NEW CashMov([
                    'cash_id' => $cash->id,
                    'mov_reason_id' => MovReason::IN_RENDICION_COBRANZA,
                    'payment_method_id' => $payment_method_id,
                    'amount' => $total,
                    'description' => 'RENDICION ' . $route->name . ' '. date_create_from_format('Y-m-d', $fees[0]->paid_date)->format('d/m/Y'),
                    'reference' => $route->name,
                    'method' => 'RENDICION COBRADOR ' . $payment_method->name
                ]);


                $cash->movements()->save($mv);

                if ($paycheck_total > 0) {
                    $mv = NEW CashMov([
                        'cash_id' => $cash->id,
                        'mov_reason_id' => MovReason::IN_CHEQUE,
                        'payment_method_id' => PaymentMethod::CHEQUE,
                        'amount' => $paycheck_total,
                        'description' => 'RENDICION ' . $route->name. ' '. date_create_from_format('Y-m-d', $fees[0]->paid_date)->format('d/m/Y'),
                        'reference' => $route->name,
                        'method' => 'RENDICION COBRADOR CHEQUE',
                    ]);
                    $cash->movements()->save($mv);
                }

                if ($mercadopago_total > 0) {
                    $mv = NEW CashMov([
                        'cash_id' => $cash->id,
                        'mov_reason_id' => MovReason::IN_MERCADOPAGO, //hardcode mercadopago
                        'payment_method_id' => PaymentMethod::MERCADOPAGO,
                        'amount' => $mercadopago_total,
                        'description' => 'RENDICION ' . $route->name. ' '. date_create_from_format('Y-m-d', $fees[0]->paid_date)->format('d/m/Y'),
                        'reference' => $route->name,
                        'method' => 'RENDICION COBRADOR MERCADOPAGO',
                    ]);
                    $cash->movements()->save($mv);
                }
            }

            DB::commit();
            return response()->json([
                'message' => 'COBRANZA GENERADA CORRECTAMENTE',
                'status' => 200
            ], 200);

        } catch (Exception $e) {
            DB::Rollback();
            return response()
                ->json([
                    'message' => $e->getMessage(),
                    'status' => 400
                ], 400);
        }
    }

    public function json(Request $request)
    {
        if (!is_null($request->input('credit_id'))) {
            $credit = Credit::with(['fees', 'articles'])->find($request->input('credit_id'));
        }
        return response()->json($credit);

    }

    public function updateObservation(Request $request)
    {   
        $creditObservation='';
        if(isset($request->id)){
            $creditObservation = Credit::find($request->id);
            $creditObservation->observation = $request->observation;
        }
        if ($creditObservation->save()) {
            return json_encode(true);
        } else {
            return json_encode(false);
        }
    }
    
    public function feeJson(Request $request)
    {
        $data = ['total' => 0, 'fees' => []];
        if (!is_null($request->input('credit_id'))) {
            $data['total'] = Credit::find($request->input('credit_id'))->total_amount;
            $data['fees'] = Fee::where('credit_id', '=', $request->input('credit_id'))
                ->with(['reason'])
                ->get();
        }
        return response()->json($data);
    }

    public function showCreditTotal()
    {
        // TODO REMOVE THIS
        $hardcodedUsers = ['admin@mencred.com', 'daniel.lucero@mencred.com', 'pablo.bustamante@mencred.com'];
        $userEmail = Auth::user()->email;
        if (in_array($userEmail, $hardcodedUsers, true)) {
            $pathTotal = 'reports.credits.total';
            $routes = Route::all();
            return view($pathTotal . '.creditsTotal', compact('routes'));
        }
        return view('home');
    }

    public function getCreditsByRoute(Request $request)
    {
        $date_init = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_init)));
        $date_end = date('Y-m-d', strtotime(str_replace('/', '-', $request->date_end)));
        $route_id = $request->route_id ?: null;

        $data = Credit::where('init_date', '>=', $date_init)
            ->where('init_date', '<=', $date_end)
            ->when($route_id, function ($q) use ($route_id) {
                $q->where('customers.route_id', '=', $route_id);
            })
            ->whereIn('status_id',[Status::OPERANDO])
            ->select(['credits.init_date', 'customers.name as customer', 'routes.name as route', 'sellers.name as seller', 'credits.total_amount', 'status.status', 'customers.commercial_address', 'neighborhoods.name as commercial_neighborhood', 'towns.name as commercial_town', 'districts.name as commercial_district', DB::RAW('sum(fees.paid_amount) as paid')])
            ->join('customers', 'customers.id', '=', 'credits.customer_id')
            ->join('sellers', 'customers.seller_id', '=', 'sellers.id')
            ->join('routes', 'customers.route_id', '=', 'routes.id')
            ->join('districts', 'customers.commercial_district_id', '=', 'districts.id')
            ->join('neighborhoods', 'customers.commercial_neighborhood_id', '=', 'neighborhoods.id')
            ->join('towns', 'customers.commercial_town_id', '=', 'towns.id')
            ->join('fees', 'fees.credit_id', '=', 'credits.id')
            ->join('status', 'credits.status_id', '=', 'status.id')
            ->orderBy('credits.init_date')
            ->groupBy('credits.id')
            ->get();

        return response()->json($data, 200);
    }

}
