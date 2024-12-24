<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class IzipayController extends Controller
{

    public function index(){
        return view('izipay.index');
    }

    public function checkout(Request $request){
        // Obtener la configuración incial del formulario
        $paymentConfig = $this->initForm();

        $paymentConfig["vads_cust_first_name"] = $request->input("firstName");
        $paymentConfig["vads_cust_last_name"] = $request->input("lastName");
        $paymentConfig["vads_cust_email"] = $request->input("email");
        $paymentConfig["vads_cust_phone"] = $request->input("phoneNumber");
        $paymentConfig["vads_cust_national_id"] = $request->input("identityCode");
        $paymentConfig["vads_cust_address"] = $request->input("address");
        $paymentConfig["vads_cust_country"] = $request->input("country");
        $paymentConfig["vads_cust_state"] = $request->input("state");
        $paymentConfig["vads_cust_city"] = $request->input("city");
        $paymentConfig["vads_cust_zip"] = $request->input("zipCode");
        $paymentConfig["vads_order_id"] = $request->input("orderId");
        $paymentConfig["vads_amount"] = $request->input("amount") * 100;
        $paymentConfig["vads_currency"] = $request->input("currency") == "PEN" ? 604:840;
        $paymentConfig["vads_url_return"] = url('/result');
        $paymentConfig["vads_return_mode"] = "POST";

        // Generar el signature
        $paymentConfig["signature"] = $this->getSignature($paymentConfig, env('CLAVE'));

        return view('izipay.checkout', ['data' => $paymentConfig]);
    }
    public function result(Request $request){
        // obtener el resultado de pago
        $data = $request->input();

        // comparar si la firma es válida
        if( $this->getSignature($data, env('CLAVE'))  !== $data["signature"]) return new Exception("Invalid signature");
        
        return view('izipay.result', compact("data"));
    }

    // Configuración de pago
    private function initForm()
    {
        date_default_timezone_set("UTC");
        return array(
            "vads_action_mode" => "INTERACTIVE",
            "vads_amount" => 0,
            "vads_ctx_mode" => env('MODE'),
            "vads_currency" => 604,
            "vads_cust_address" => "", 
            "vads_cust_city" => "",
            "vads_cust_country" => "",
            "vads_cust_email" => "",
            "vads_cust_first_name" => "",
            "vads_cust_last_name" => "",
            "vads_cust_national_id" => "",
            "vads_cust_phone" => "",
            "vads_cust_state" => "",
            "vads_cust_zip" => "",
            "vads_order_id" => "",
            "vads_page_action" => "PAYMENT",
            "vads_payment_config" => "SINGLE",
            "vads_return_mode" => "POST",
            "vads_site_id" => env('SHOP_ID'),
            "vads_trans_date" => date("YmdHis"),
            "vads_trans_id" => substr(md5(time()), -6),
            "vads_url_return" => url("result"),
            "vads_version" => "V2",
            "signature" => "",
        );
    }

    private function getSignature($params, $key)
    {
        $content_signature = "";
        // Ordenar los campos alfabéticamente
        ksort($params);
        foreach ($params as $name => $value) {
            // Recuperación de los campos vads_
            if (substr($name, 0, 5) == 'vads_') {
                // Concatenación con el separador "+"
                $content_signature .=  $value . "+";
            }
        }
        // Añadir la clave al final del string
        $content_signature .= $key;
        // Codificación base64 del string cifrada con el algoritmo HMAC-SHA-256
        $signature = base64_encode(hash_hmac('sha256', utf8_encode($content_signature), $key, true));
        return $signature;
    }

    public function notificationIpn(Request $request)
    {
        if (!$request->has('vads_hash')) {
            return response("Invalid data", 400);
        }

        $signature = $this->getSignature($request->input(), env('CLAVE'));

        if ($request->input('signature') !== $signature) {
            return response("Signature Invalid", 200);
        }

        return response("Transaccion is {$request->input('vads_trans_status')}!", 200);
    }
}
