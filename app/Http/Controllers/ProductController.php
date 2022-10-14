<?php

namespace App\Http\Controllers;
use App\Services\Interfaces\CategoryInterface;
use App\Services\Interfaces\ProductInterface;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    private CategoryInterface $categoryInterface;
    private ProductInterface $productInterface;

    public function __construct(CategoryInterface $categoryInterface, ProductInterface $productInterface )
    {
        $this->categoryInterface = $categoryInterface;
        $this->productInterface = $productInterface;
    }

    public function index($productId)
    {
        $product = $this->productInterface->getProductsById($productId);
        return view('pages.detail-product', $product);
    }
}
