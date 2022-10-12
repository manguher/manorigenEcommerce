<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\CategoryInterface;
use App\Services\Interfaces\ProductInterface;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private CategoryInterface $categoryInterface;
    private ProductInterface $productInterface;

    public function __construct(CategoryInterface $categoryInterface, ProductInterface $productInterface )
    {
        $this->categoryInterface = $categoryInterface;
        $this->productInterface = $productInterface;
    }

    public function add($productoId){
        $product = $this->productInterface->getProductsById($productoId);
        foreach ($product as $key => $value) {
            Cart::add(
                $value['id'], 
                $value['name'], 
                $value['name'], 
            );
        }
    }
}
