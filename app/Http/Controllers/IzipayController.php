<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class IzipayController extends Controller
{
    public function index()
    {
        return view('izipay.index');
    }

    public function checkout(Request $request)
    {
        $parameters = $this->dataForm($request);

        return view('izipay.checkout', ['parameters' => $parameters]);
    }

    public function result(Request $request)
    {
        if (empty($request->input())) {
            return response('No post data received!', 400);
        }

        if (!$this -> checkSignature($request->input())){
            return response("Invalid signature", 400);
        }

        $data = $request->input();
        
        return view('izipay.result', compact("data"));
    }

    public function notificationIpn(Request $request)
    {
        if (empty($request->input())) {
            return response('No post data received!', 400);
        }

        if (!$this -> checkSignature($request->input())){
            return response("Invalid signature", 400);
        }

        //Verificar orderStatus: AUTHORISED
        $orderStatus = $request->input('vads_trans_status');
        $orderId = $request->input('vads_order_id');
        $transactionUuid = $request->input('vads_trans_uuid');

        return response("OK! OrderStatus is {$orderStatus}!", 200);
    }
}
