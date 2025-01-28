<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashfreeController extends Controller
{
    public function fatchCashFreeToken()
    {
        $cashfree_key = '197029dfc16098ea8d68abb48a920791';
        $cashfree_secret = 'c26826d61fd2e0322c6713e40628748c3689b04a';
        if (Auth::user()) {
            $id = Auth::user()->id;
            $mobile = Auth::user()->phone;
            $email = $_POST['customer_email'];
            $order_amount = $_POST['order_amount'];
            $order_note = $_POST['order_note'];
            $data = [
                'customer_details' => [
                    'customer_id' => (string)$id,
                    'customer_email' => $email,
                    'customer_phone' => $mobile,
                ],
                'order_amount' => $order_amount,
                'order_currency' => 'INR',
                'order_note' => $order_note
            ];
            $data = json_encode($data);

            $url =  'https://sandbox.cashfree.com/pg/orders';
            $headers = [
                'accept: application/json',
                'content-type: application/json',
                'x-api-version: 2022-01-01',
                'x-client-id: 197029dfc16098ea8d68abb48a920791',
                'x-client-secret: c26826d61fd2e0322c6713e40628748c3689b04a'
            ];

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($curl);

            if ($response === false) {
                // Handle cURL error
                $error = curl_error($curl);
                // Handle the error accordingly
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['error' => $error]);
                die();
            } else {
                $result = json_decode($response, true);
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(['order_token' => $result['order_token']]);
                die();
            }

            curl_close($curl);
        }
    }
}
