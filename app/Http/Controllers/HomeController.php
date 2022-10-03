<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\CategoryInterface;
use App\Services\Interfaces\ProductInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    private CategoryInterface $categoryInterface;
    private ProductInterface $productInterface;

    public function __construct(CategoryInterface $categoryInterface, ProductInterface $productInterface )
    {
        $this->categoryInterface = $categoryInterface;
        $this->productInterface = $productInterface;
    }

    public function index()
    {
        $category = $this->categoryInterface->getAllCategories(); 
        $product = $this->productInterface->getAllProducts();
        $viewShareVars = array_keys(get_defined_vars());

        return view('pages.home', compact($viewShareVars));
    }

    public function getAllProductsByCategoryId($categoryId)
    {  
        $productsByCategory = $this->productInterface->getProductsByCategoryId($categoryId);
        $html = view('pages.home-product')
                ->with('productsHome', $productsByCategory)
                ->render();
        return response()->json($html);
    }
}
