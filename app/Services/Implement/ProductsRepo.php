<?php

namespace App\Services\Implement;

use App\Services\Interfaces\ProductInterface;
use App\Services\Interfaces\CategoryInterface;
use GuzzleHttp\Client;
use Protechstudio\PrestashopWebService\PrestashopWebService;

class ProductsRepo implements ProductInterface
{
    protected $url;
    protected $http;    
    protected $headers;
    private CategoryInterface $categoryInterface;
    private $prestashop;

    public function __construct(Client $client, CategoryInterface $categoryInterface, PrestashopWebService $prestashop)
    {
        $this->url = config('constants.apiUrl');
        $this->http = $client;
        $this->headers = [
            'cache-control' => 'no-cache',
            'content-type' => 'application/x-www-form-urlencoded',
        ];

        $this->categoryInterface = $categoryInterface;
        $this->prestashop = $prestashop;
    }

    public function getAllProducts()
    {
        $full_path = $this->url . '/api/products?ws_key=' . config('constants.apiKey') . '&display=full&output_format=JSON';
        $response = $this->http->get($full_path, [
            'headers'         => $this->headers,
            'timeout'         => 30,
            'connect_timeout' => 30,
            'http_errors'     => true,
        ]);
        return json_decode($response->getBody(), true);
    }

    public function getProductsByCategoryId($categoryId)
    {
        $allProducts = $this->getAllProducts();
        $category = $this->categoryInterface->getAllCategories();
        $productsIds = array();;
        $productsLst = array();

        //filter category 
        foreach ($category as $value) {
            if ($value['id'] == $categoryId) {
                $associations = $value['associations'];
                $productsIds = $associations['products'];
                foreach ($productsIds as $key => $productObject) {
                    $productsIds[$key]['id_parent_category'] = $value['id'];
                }
            }
        }

        //filter products 
        foreach ($productsIds as $item) {
            foreach ($allProducts['products'] as $key => $value) {
                if ($item['id'] == $value['id']) {
                    $allProducts['products'][$key]['id_parent_cat'] = $item['id_parent_category'];
                    $allProducts['products'][$key]['url_image_default'] =  $this->url . '/api/images/products/' . $item['id'] . '/' . $value['id_default_image'] . '?ws_key=' . config('constants.apiKey');
                    array_push($productsLst, $allProducts['products'][$key]);
                }
            }
        }
        return $productsLst;
    }

    public function getProductsById($productId)
    {
        // get obj
        $full_path = $this->url . '/api/products/' . $productId . '?ws_key=' . config('constants.apiKey') . '&display=full&output_format=JSON';
        $response = $this->http->get($full_path, [
            'headers'         => $this->headers,
            'timeout'         => 30,
            'connect_timeout' => 30,
            'http_errors'     => true,
        ]);

        // add image url
        $res = json_decode($response->getBody(), true);
        foreach ($res['products'] as $key => $value) {
            $combinationLst = $res['products'][0]['associations']['combinations'];
            $res['products'][$key]['url_image_default'] =  $this->url . '/api/images/products/' . $value['id'] . '/' . $value['id_default_image'] . '?ws_key=' . config('constants.apiKey');
            $res['products'][$key]['associations']['combinations']  = $this->getProductCombinations($combinationLst);

            $stock = 0;
            foreach ($res['products'][$key]['associations']['combinations'] as $combi) {
                $stock += $combi['quantity'];
            }
            $res['products'][$key]['stock'] = $stock > 0 ? 'Disponible' : 'Sin Stock';
        }
        return $res;
    }

    public function getProductCombinations($combinationLst)
    {
        // get obj
        $full_path = $this->url . '/api/combinations/?ws_key=' . config('constants.apiKey') . '&display=full&output_format=JSON';
        $response = $this->http->get($full_path, [
            'headers'         => $this->headers,
            'timeout'         => 30,
            'connect_timeout' => 30,
            'http_errors'     => true,
        ]);

        $combinations = [];
        $Allcombination = json_decode($response->getBody(), true);
        foreach ($combinationLst as $key => $item) {
            foreach ($Allcombination['combinations'] as $key => $value) {
                if($item['id'] == $value['id']){
                    array_push($combinations, $value);
                    break;
                }
            }
        }
        return $combinations;
    }
}
