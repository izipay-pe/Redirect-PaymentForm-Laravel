<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function dataForm(Request $request)
    {
        $newParams = [
            "vads_action_mode" => "INTERACTIVE",
            "vads_amount" => $request->input("amount") * 100,
            "vads_ctx_mode" => "TEST", // TEST O PRODUCTION
            "vads_currency" => $request->input("currency") == "PEN" ? 604 : 840, // Código ISO 4217
            "vads_cust_address" => $request->input("address"),
            "vads_cust_city" => $request->input("city"),
            "vads_cust_country" => $request->input("country"),
            "vads_cust_email" => $request->input("email"),
            "vads_cust_first_name" => $request->input("firstName"),
            "vads_cust_last_name" => $request->input("lastName"),
            "vads_cust_national_id" => $request->input("identityCode"),
            "vads_cust_phone" => $request->input("phoneNumber"),
            "vads_cust_state" => $request->input("state"),
            "vads_cust_zip" => $request->input("zipCode"),
            "vads_order_id" => $request->input("orderId"),
            "vads_page_action" => "PAYMENT",
            "vads_payment_config" => "SINGLE",
            "vads_redirect_success_timeout" => 5,
            "vads_return_mode" => "POST",
            "vads_site_id" => env('SHOP_ID'),
            "vads_trans_date" => now()->format('YmdHis'), // Fecha en formato UTC
            "vads_trans_id" => substr(md5(time()), -6),
            "vads_url_return" => "http://localhost/Redirect-PaymentForm-Laravel-main/public/result", // URL de retorno
            "vads_version" => "V2",
        ];

        //Calcular la firma
        $newParams["signature"] = $this->calculateSignature($newParams, env('KEY'));

        return $newParams;
    }

    protected function calculateSignature($parameters, $key)
    {
        $content_signature = "";
        // Ordenar los campos alfabéticamente
        ksort($parameters);
        foreach ($parameters as $name => $value) {
          if (substr($name, 0, 5) == 'vads_') {
            $content_signature .=  $value . "+";
          }
        }
        // Añadir la clave al final del string
        $content_signature .= $key;
        // Codificación base64 del string cifrada con el algoritmo HMAC-SHA-256
        $signature = base64_encode(hash_hmac('sha256', mb_convert_encoding($content_signature, "UTF-8"), $key, true));
        return $signature;
    }

    protected function checkSignature($parameters)
    {
        $signature = $parameters['signature'];

        return $signature == $this->calculateSignature($parameters, env('KEY'));
    }
}
