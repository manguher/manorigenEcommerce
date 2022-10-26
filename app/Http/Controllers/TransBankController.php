<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Transbank\Webpay\WebpayPlus;
use Transbank\Webpay\WebpayPlus\Transaction;

class TransBankController extends Controller
{
    public function __construct()
    {
        if (app()->environment('production')) {
            WebpayPlus::configureForProduction(
                env('webpay_plus_cc'),
                env('webpay_plus_api_key'),
            );
        } else
            WebpayPlus::configureForTesting();
    }

    public function index(Request $request)
    {
       $urlToPay = self::initWebPayTransaction($request);
       return $urlToPay;
    }

    public function initWebPayTransaction(Request $request)
    {
        $transaction = (new Transaction)->create(
            123,
            "123456",
            111,
            route('payment_confirm')
        );

        $url = $transaction->getUrl().'?token_ws='.$transaction->getToken();
        return $url;
    }
}
