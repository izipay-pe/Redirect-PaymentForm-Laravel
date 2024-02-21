<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

use Lyra\Client;
use Lyra\Exceptions\LyraException;

class IzipayController extends Controller
{

    public function initPaymentForm()
    {
        $order = uniqid('order-');
        return view('izipay.index', compact('order'));
    }

    public function confirm(Request $request)
    {
        $paymentConfig = $this->initForm();

        $paymentConfig["vads_cust_first_name"] = $request->input("firstname");
        $paymentConfig["vads_cust_last_name"] = $request->input("lastname");
        $paymentConfig["vads_cust_email"] = $request->input("email");
        $paymentConfig["vads_order_id"] = $request->input("order");
        $paymentConfig["vads_amount"] = intval($request->input("amount")) * 100;
        $paymentConfig["vads_url_return"] = url('/status?order=' . $request->input("order"));
        $paymentConfig["vads_return_mode"] = "GET";
        $paymentConfig["signature"] = $this->getSignature($paymentConfig, env('CLAVE'));

        return view('izipay.confirm', ['data' => $paymentConfig, 'URL' => env('URL_PAYMENT')]);
    }

    private function initForm()
    {
        date_default_timezone_set("UTC");
        return array(
            "vads_action_mode" => "INTERACTIVE",
            "vads_amount" => 0,
            "vads_ctx_mode" => env('MODE'),
            "vads_currency" => 604,
            "vads_page_action" => "PAYMENT",
            "vads_payment_config" => "SINGLE",
            "vads_site_id" => env('SHOP_ID'),
            "vads_trans_date" => date("YmdHis"),
            "vads_trans_id" => substr(md5(time()), -6),
            "vads_version" => "V2",
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

    public function status(Request $request)
    {
        $args = $request->query();
        $amount = intval($args['vads_amount']) / 100;

        return view('izipay.status', ['data' => $args, 'amount' => $amount]);
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
