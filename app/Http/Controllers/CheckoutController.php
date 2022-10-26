<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\CartInterface;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    private CartInterface $cartInterface;

    public function __construct( CartInterface $cartInterface)
    {
        $this->cartInterface = $cartInterface;
    }

    public function index(Request $request)
    {
        $cart = $this->cartInterface->getCart();
        return view('pages.checkout',  compact('cart'));
    }
}
