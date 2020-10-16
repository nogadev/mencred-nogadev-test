<?php

namespace App\Http\Controllers;

use Auth;

use App\Models\CashPaymentMethod;
use Illuminate\Support\Facades\Redirect;
use App\Models\PaymentMethod;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PaymentDetail;
use App\Models\MovReason;
use App\Models\CashMov;
use App\Models\Bank;
use App\Models\MovType;
use App\Models\Cash;


use App\Http\Requests\CashMovementValidator;

use DB;

class CashController extends Controller
{
    private $path = 'cashes';

    public function __construct()
    {
        $this->movementtypes    = MovType::all();
        $this->movementreasons  = MovReason::all();
        $this->banks            = Bank::all();
        $this->payment_methods  = PaymentMethod::all();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();        
        if ($user->email == "admin@mencred.com"
            || $user->email == "daniel.lucero@mencred.com"
            || $user->email == "pablo.bustamante@mencred.com"
            || $user->email == "enzo.marino@mencred.com") {                
            return view($this->path . '.index');
        } else {
            return redirect("/");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type = null)
    {
        $user = Auth::user();        
        if ($user->email == "admin@mencred.com"
            || $user->email == "daniel.lucero@mencred.com"
            || $user->email == "pablo.bustamante@mencred.com"
            || $user->email == "enzo.marino@mencred.com") {

            $cash = $this->getCurrentCash();

            if(!is_null($cash)){

                $isPrevCash = $this->isPrevCashOpen($cash);

                $this->paychecks  = PaymentDetail::with('bank')->where('status_id','=',Status::CARTERA)
                    ->where('payment_method_id','=',PaymentMethod::CHEQUE)->get();

                $this->mercadopago  = PaymentDetail::with('bank')->where('status_id','=',Status::CARTERA)
                    ->where('payment_method_id','=',PaymentMethod::MERCADOPAGO)->get();


                return view($this->path.'.create')
                    ->with('movementtypes', $this->movementtypes)
                    ->with('movementtype_id', $type)
                    ->with('payment_methods', $this->payment_methods)
                    ->with('paychecks', $this->paychecks)
                    ->with('banks', $this->banks)
                    ->with('isPrevCash', $isPrevCash)
                    ->with('mercadopago', $this->mercadopago)
                    ->with('cash', $cash);
            }
            else{
                $currentDate = Carbon::today();
                $isCloseCash = $this->isCloseCashOfDay($currentDate->format('Y-m-d'));
                return view($this->path. '.init')
                    ->with('isCloseCash', $isCloseCash)
                    ->with('date', $currentDate->format('d/m/Y'));
            }
        } else {
            return redirect("/");
        }
    }

    public static function getCurrentCash(){
        $cash = Cash::with('movements','movements.movreasons', 'movements.paymentmethods', 'movements.checks')
            ->where('status_id', '=', Status::ABIERTA)
            ->first();
        return $cash;
    }

    private function isCloseCashOfDay($date){
        $currentDayCash =
            Cash::where('status_id', '=', Status::CERRADA)
                ->where('date_of','=',$date)
                ->first();
        return !is_null($currentDayCash);
    }

    private function isPrevCashOpen($cash){
        return $cash->date_of < Carbon::now()->format('Y-m-d');
    }

    private static function validateCash(){
        $cash = Cash::where('status_id','=',Status::ABIERTA)->first();

        if(is_null($cash)){
            return false;
        }
        else{
            if($cash->date_of < Carbon::now()->format('Y-m-d')){
                return false;
            }
            else{
                return true;
            }
        }
    }

    public static function validateCurrentCash(){
        if(!self::validateCash()){
            return false;
        } else {
            return true;
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Cash $cash)
    {
        return view($this->path.'.show')
            ->with('cash', $cash);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }


    public function storeMovement(CashMovementValidator $request)
    {
        $cash = Cash::find($request->cash_id);

        if(!is_null($cash))
        {
            if($request->payment_detail_id)
            {
                $pd = PaymentDetail::find($request->payment_detail_id);
                $pd->status_id  = Status::ENTREGADO;
                $pd->save();
            }


            $mv = CashMov::firstOrNew(array('id' => $request->movement_id));
            $mv->amount = $request->amount;
            $mv->method = 'MANUAL';
            $mv->description = $request->description;
            $mv->mov_reason_id = $request->mov_reason_id;
            $mv->payment_method_id= $request->payment_method_id;
            $mv->cash_id= $request->cash_id;
            if(isset($request->reference)) {
                $mv->reference= $request->reference;
            }
            else{
                $mv->reference = 'MANUAL';
            }

            $ret = $cash->movements()->save($mv);

            $cash->balance = ($cash->ingresos->total ?? 0) - ($cash->egresos->total ?? 0);
            $cash->save();

            $cashMov = CashMov::with('movreasons','paymentmethods','checks')
                ->where('id', '=', $ret->id)
                ->first();
        }
        return response()->json($cashMov);
    }

    public function destroyMovement(Request $request)
    {
        $ret = false;
        if($request->id)
        {
            $ret = CashMov::destroy($request->id);
        }
        return response()->json($ret);
    }

    public static function openCash()
    {
        $previewCash   = Cash::where('status_id','=',Status::CERRADA)->orderby('id','desc')->first();

        $previewChecks = $previewMercadopago = $previewBank = $previewEfectivo = $previewCashAmount = 0;

        if(!is_null($previewCash)){
            $previewChecks = $previewCash->totalChecks[0]->pivot->amount;
            $previewMercadopago = $previewCash->totalMercadopago[0]->pivot->amount;
            $previewBank = $previewCash->totalBanks[0]->pivot->amount;
            $previewEfectivo = $previewCash->totalEfectivo[0]->pivot->amount;
            $previewCashAmount = $previewChecks + $previewMercadopago + $previewBank + $previewEfectivo;
            $previewDate = Carbon::parse($previewCash->date_of)->format('d/m/Y');
        }

        DB::BeginTransaction();

        $cash = new Cash();
        $cash->date_of = date('Y-m-d');
        $cash->status_id = Status::ABIERTA;
        $cash->balance = $previewCashAmount;


        try {
            $cash->save();

            if(!is_null($previewCash)){
                $movement = [];

                $mv_ef = NEW CashMov([
                    'cash_id' => $cash->id,
                    'mov_reason_id' => MovReason::IN_APERTURA_CAJA,
                    'payment_method_id' => PaymentMethod::EFECTIVO,
                    'amount' => $previewEfectivo,
                    'description' => 'CAJA ' . $previewDate . '-EFECTIVO',
                    'reference' => $previewCash->id
                ]);

                $mv_ch = NEW CashMov([
                    'cash_id' => $cash->id,
                    'mov_reason_id' => MovReason::IN_APERTURA_CAJA,
                    'payment_method_id' => PaymentMethod::CHEQUE,
                    'amount' => $previewChecks,
                    'description' => 'CAJA ' . $previewDate . '-CHEQUES',
                    'reference' => $previewCash->id
                ]);

                $mv_mp = NEW CashMov([
                    'cash_id' => $cash->id,
                    'mov_reason_id' => MovReason::IN_APERTURA_CAJA,
                    'payment_method_id' => PaymentMethod::MERCADOPAGO,
                    'amount' => $previewMercadopago,
                    'description' => 'CAJA ' . $previewDate . '-MERCADO PAGO',
                    'reference' => $previewCash->id
                ]);

                $mv_bk = NEW CashMov([
                    'cash_id' => $cash->id,
                    'mov_reason_id' => MovReason::IN_APERTURA_CAJA,
                    'payment_method_id' => PaymentMethod::BANCO,
                    'amount' => $previewBank,
                    'description' => 'CAJA ' . $previewDate . '-BANCO',
                    'reference' => $previewCash->id
                ]);


                array_push($movement, $mv_ef, $mv_ch, $mv_mp, $mv_bk);

                foreach ($movement as $mv){
                    $cash->movements()->save($mv);
                }
            }

            DB::commit();
        } catch(\Exception $e){
            DB::rollback();
            die(var_dump($e));
        }

        return redirect()->route('cash.actual');
    }

    public function closeCash(){

        $currentCash = Cash::where('status_id','=',Status::ABIERTA)->orderby('id','desc')->first();

        if(!is_null($currentCash)){
            $checksIn = $currentCash->totalInputChecks->first()->total;
            $checksOut = $currentCash->totalOutputChecks->first()->total;
            $checks = $checksIn - $checksOut;

            $mercadopagoIn = $currentCash->totalInputMercadopago->first()->total;
            $mercadopagoOut = $currentCash->totalOutputMercadopago->first()->total;
            $mercadopago =  $mercadopagoIn - $mercadopagoOut;

            $bankIn = $currentCash->totalInputBank->first()->total;
            $bankOut = $currentCash->totalOutputBank->first()->total;
            $bank = $bankIn - $bankOut;

            $moneyCashIn = $currentCash->totalInputMoneyCash->first()->total;
            $moneyCashOut = $currentCash->totalOutputMoneyCash->first()->total;
            $moneyCash = $moneyCashIn - $moneyCashOut;


            DB::BeginTransaction();

            try {

                $mv = [];

                $mvMc = [
                    'cash_id' => $currentCash->id,
                    'payment_method_id' => PaymentMethod::EFECTIVO,
                    'amount' => $moneyCash
                ];

                $mvCh = [
                    'cash_id' => $currentCash->id,
                    'payment_method_id' => PaymentMethod::CHEQUE,
                    'amount' => $checks
                ];

                $mvMp = [
                    'cash_id' => $currentCash->id,
                    'payment_method_id' => PaymentMethod::MERCADOPAGO,
                    'amount' => $mercadopago
                ];

                $mvBk = [
                    'cash_id' => $currentCash->id,
                    'payment_method_id' => PaymentMethod::BANCO,
                    'amount' => $bank
                ];

                array_push($mv, $mvMc, $mvCh, $mvMp, $mvBk);

                foreach ($mv as $payment){
                    $currentCash->payments_methods()->attach($currentCash->id, $payment);
                }


                $currentCash->balance = $moneyCash + $checks + $mercadopago + $bank;
                $currentCash->status_id = Status::CERRADA;
                $currentCash->save();


                DB::commit();
            } catch(\Exception $e){
                DB::rollback();
            }
        }

        return redirect()->route('cash.actual');
    }

    public function getAmountAvailableMercadoPago(){

        $currentCash = self::getCurrentCash();

        $mercadopagoIn = $currentCash->totalInputMercadopago->first()->total;
        $mercadopagoOut = $currentCash->totalOutputMercadopago->first()->total;
        $mercadopago =  $mercadopagoIn - $mercadopagoOut;
        if($mercadopago < 0){
            $mercadopago = 0;
        }
        return response()->json($mercadopago);

    }

    public function showCashReport(Request $request)
    {
        $user = Auth::user();        
        if ($user->email == "admin@mencred.com"
            || $user->email == "daniel.lucero@mencred.com"
            || $user->email == "pablo.bustamante@mencred.com"
            || $user->email == "enzo.marino@mencred.com") {                
            
        $pathCash = 'reports.cashes.cashes';
    	$movementtypes = MovType::all();
    	$movementreasons = MovReason::all();

        return view($pathCash, compact('movementtypes','movementreasons'));
        
        } else {
            return redirect("/");
        }        
    }
    
    public function getCashDetail(Request $request)
    {
        $date_init = $request->date_init?: date('Y-m-d');
        $date_end  = $request->date_end ?: date('Y-m-d');
        $mov_reason_id = $request->mov_reason_id ?: null;
        $movementtype_id = $request->movementtype_id ?: null;
        $data = CashMov::when($date_init, function($q) use ($date_init){
                $q->where('cashes.date_of','>=',$date_init);
            })
            ->when($date_end, function($q) use ($date_end){
                $q->where('cashes.date_of','<=',$date_end);
            })
            ->when($mov_reason_id, function($q) use ($mov_reason_id){
                $q->where('mov_reason_id','=', $mov_reason_id );
            })
            ->when($movementtype_id, function($q) use ($movementtype_id){
                $q->where('mov_type_id','=', $movementtype_id );
            })
            ->select(['cashes.date_of','mov_reasons.description as mov_reason','payment_methods.name as payment_method','cash_movs.description','cash_movs.amount'])
            ->join('cashes','cash_movs.cash_id','=','cashes.id')
            ->join('mov_reasons','cash_movs.mov_reason_id','=','mov_reasons.id')
            ->join('payment_methods','cash_movs.payment_method_id','=','payment_methods.id')
            ->orderBy('cashes.date_of','DESC')
            ->get();

        return response()->json($data, 200);
    }

    public function getCashFromDate(Request $request){

        $cash = Cash::with('movements','movements.movreasons', 'movements.paymentmethods')
            ->where('date_of', '=', $request->date)
            ->first();
        return response()->json($cash);
    }

    public function getMovsByCheck(Request $request){
        $cashMov = CashMov::with('movreasons','paymentmethods','checks')
            ->where('reference', '=', $request->check_id)
            ->get();
        return response()->json($cashMov);
    }

}
