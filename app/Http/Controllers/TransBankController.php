<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Transbank\Webpay\WebpayPlus;
use Transbank\Webpay\WebpayPlus\Transaction;
use App\Services\Interfaces\OrderInterface;

class TransBankController extends Controller
{
    private OrderInterface $orderInterface;

    public function __construct(OrderInterface $orderInterface)
    {
        $this->orderInterface = $orderInterface;

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
        // generar orden de compra
        $this->orderInterface->createOrder($request);
        // $urlToPay = self::initWebPayTransaction($request);
        // return $urlToPay;
    }

    public function initWebPayTransaction(Request $request)
    {
        $transaction = (new Transaction)->create(
            123,
            "123456",
            111,
            route('payment_confirm')
        );
        $url = $transaction->getUrl() . '?token_ws=' . $transaction->getToken();
        return $url;
    }

    public function paymentConfirm(Request $request)
    {
        $confirmation = (new Transaction)->commit($request->get('token_ws'));
        $compra = ''; // get orden de compra
        if ($confirmation->isApproved()) {
            // actualiza orden de compra a estado aprovada (desde la API)
            return redirect(env('URL_FRONT_AFTER_PAYMENT') . "?ordenId={$compra}");
        } else {
            return redirect(env('URL_FRONT_AFTER_PAYMENT') . "?ordenId={$compra}");
        }
    }
}
