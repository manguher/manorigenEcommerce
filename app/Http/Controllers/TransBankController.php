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
        $order = $this->orderInterface->createOrder($request);
        $urlToPay = self::initWebPayTransaction($order);
        return $urlToPay;
    }

    public function initWebPayTransaction($order)
    {
        $transaction = (new Transaction)->create(
            (int)$order->id, // id order
            "123", // sesion id TODO
            (int)$order->total_paid, // total
            route('payment_confirm')
        );
        $url = $transaction->getUrl() . '?token_ws=' . $transaction->getToken();
        return $url;
    }

    public function paymentConfirm(Request $request)
    {
        $confirmation = (new Transaction)->commit($request->get('token_ws'));
        $compraId = $confirmation->buyOrder;
        if ($confirmation->isApproved()) 
        {
            $this->orderInterface->updateOrderHistoriesState($compraId, 2); // TODO id estado compra 
            \Cart::clear();
            return redirect(env('URL_FRONT_AFTER_PAYMENT') . "?ordenId={$compraId}");
        } else {
            return redirect(env('URL_FRONT_AFTER_PAYMENT') . "?ordenId={$compraId}");
        }
    }
}
