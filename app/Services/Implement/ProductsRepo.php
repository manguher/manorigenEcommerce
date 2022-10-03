<?php

namespace App\Services\Implement;

use App\Services\Interfaces\ProductInterface;
use App\Services\Interfaces\CategoryInterface;
use GuzzleHttp\Client;

class ProductsRepo implements ProductInterface
{
    protected $url;
    protected $http;
    protected $headers;
    private CategoryInterface $categoryInterface;

    public function __construct(Client $client, CategoryInterface $categoryInterface)
    {
        $this->url = config('constants.apiUrl');
        $this->http = $client;
        $this->headers = [
            'cache-control' => 'no-cache',
            'content-type' => 'application/x-www-form-urlencoded',
        ];

        $this->categoryInterface = $categoryInterface;
    }

    public function getAllProducts()
    {
        $full_path = $this->url . 'products?ws_key=' . config('constants.apiKey') . '&display=full&output_format=JSON';
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
                    $allProducts['products'][$key]['url_image_default'] =  $this->url . 'images/products/' . $item['id'] . '/' . $value['id_default_image'] . '?ws_key=' . config('constants.apiKey');
                    array_push($productsLst, $allProducts['products'][$key]);
                }
            }
        }
        return $productsLst;
    }

    public function getProductsById($productId)
    {
        $full_path = $this->url . 'products/' . $productId .'?ws_key=' . config('constants.apiKey') . '&display=full&output_format=JSON';
        $response = $this->http->get($full_path, [
            'headers'         => $this->headers,
            'timeout'         => 30,
            'connect_timeout' => 30,
            'http_errors'     => true,
        ]);
        return json_decode($response->getBody(), true);
    }
}
