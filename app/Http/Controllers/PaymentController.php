<?php

namespace App\Http\Controllers;


use App\Models\PaymentDetail;
use App\Models\Status;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request){

        $request->merge([
            'amount'    => str_replace(['$','.',','], ['','','.'], $request->amount),
            'status_id'    => Status::CARTERA
        ]);

        $paymentDetail = new PaymentDetail((array) $request->all());

        $paymentDetail->save();

        return response()->json($paymentDetail);
    }

    public function destroy(Request $request){

        $data = [
            'status' => '0',
            'msg' => 'fail'
        ];

        $res = PaymentDetail::where('id','=', $request->id)->delete();

        if ($res){
            $data = [
                'status'=>'1',
                'msg'=>'success'
            ];
        }
        return response()->json($data);
    }

    public function updateCheck(Request $request){

        $check = $request->check;

        $payment = PaymentDetail::findOrFail($check['id']);
        $payment->update([
            'status_id' => $check['status_id']
        ]);

        return response()->json($payment);
    }
}