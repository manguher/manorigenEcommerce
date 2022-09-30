<?php

namespace App\Services\Implement;

use App\Services\Interfaces\CategoryInterface;
use GuzzleHttp\Client;

class CategoryRepo implements CategoryInterface
{
    protected $url;
    protected $http;
    protected $headers;

    public function __construct(Client $client)
    {
        $this->url = config('constants.apiUrl' ) ;
        $this->http = $client;
        $this->headers = [
            'cache-control' => 'no-cache',
            'content-type' => 'application/x-www-form-urlencoded',
        ];
    }

    public function getAllCategories()
    {
        $full_path = $this -> url . 'categories?ws_key=' . config('constants.apiKey' ) . '&display=full&output_format=JSON';
        $response = $this->http->get($full_path, [
            'headers'         => $this->headers,
            'timeout'         => 100,
            'connect_timeout' => true,
            'http_errors'     => true,
        ]);
        $res = json_decode($response->getBody(), true);
        $category = collect($res['categories'])->filter(function ($value) {
            return $value['id_parent'] == '2';
        });
        return $category;
    }

    public function getProductsByCategory($contegoryId)
    {
        $full_path = $this -> url . 'products?ws_key=' . config('constants.apiKey' ) . '&display=[id, name]&output_format=JSON';
        $response = $this->http->get($full_path, [
            'headers'         => $this->headers,
            'timeout'         => 30,
            'connect_timeout' => true,
            'http_errors'     => true,
        ]);
        $res = json_decode($response->getBody(), true);
        $category = collect($res['categories'])->filter(function ($value) {
            return $value['id_parent'] == '2';
        });
        return $category;
    }

    public function getCategoriesById()
    {
        return null;
    }
}