<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\CategoryInterface;
use App\Services\Interfaces\ProductInterface;
use App\Services\Interfaces\CartInterface;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private CategoryInterface $categoryInterface;
    private ProductInterface $productInterface;
    private CartInterface $cartInterface;

    public function __construct(CategoryInterface $categoryInterface, ProductInterface $productInterface, CartInterface $cartInterface)
    {
        $this->categoryInterface = $categoryInterface;
        $this->productInterface = $productInterface;
        $this->cartInterface = $cartInterface;
    }

    public function add(Request $request, $productoId)
    {
        $userSession = $request->session()->has('idCustomer');
        if (!$request->session()->has('idCustomer'))
            $request->session()->put('idCustomer', 123);

        $cartCountItems = $this->cartInterface->addCart($productoId);
        $html = view('pages.header-cart', compact('cartCountItems'));
        return $html;
    }

    public function detail()
    {
        $cart = $this->cartInterface->getCart();
        return view('pages.detail-cart',  compact('cart'));
    }

    public function deleteItem($productId)
    {
        $this->cartInterface->deleteItem($productId);
        $cart = $this->cartInterface->getCart();
        $cartCountItems = count(\Cart::getContent());
        $htmlGrid = view('pages.grid-cart', compact('cart'))->render();
        return response()->json([
            'htmlGrid' => $htmlGrid,
            'cartCount' => $cartCountItems
        ]);
    }
}
