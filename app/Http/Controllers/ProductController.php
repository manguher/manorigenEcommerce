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
        try {
            // creating webservice access
            $webService = new PrestaShopWebservice('http://example.com/', 'ZR92FNY5UFRERNI3O9Z5QDHWKTP3YIIT', false);
         
            // call to retrieve all customers
            $xml = $webService->get(['resource' => 'customers']);
        } catch (PrestaShopWebserviceException $ex) {
            // Shows a message related to the error
            echo 'Other error: <br />' . $ex->getMessage();
        }
        $product = $this->productInterface->getProductsById($productId);
        return view('pages.detail-product', $product);
    }
}
