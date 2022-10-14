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

    public function add(Request $request, $productoId){
        $userSession = $request->session()->has('idCustomer');
        if(!$request->session()->has('idCustomer'))
            $request->session()->put('idCustomer', 123);

        $product = $this->cartInterface->addCart($productoId);
        return null;
    }
}
