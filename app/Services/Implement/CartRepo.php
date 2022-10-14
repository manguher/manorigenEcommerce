<?php

namespace App\Services\Implement;

use App\Services\Interfaces\CartInterface;
use Darryldecode\Cart\Cart;
use GuzzleHttp\Client;
use Protechstudio\PrestashopWebService\PrestashopWebService;
use Illuminate\Support\Facades\Auth;

class CartRepo implements CartInterface
{
    protected $url;
    protected $http;
    protected $headers;
    private $prestashop;

    public function __construct(Client $client, PrestashopWebService $prestashop)
    {
        $this->url = config('constants.apiUrl');
        $this->http = $client;
        $this->headers = [
            'cache-control' => 'no-cache',
            'content-type' => 'application/x-www-form-urlencoded',
        ];

        $this->prestashop = $prestashop;
    }

    // public function getAllCategories() 
    // {
    //     $full_path = $this->url . 'categories?ws_key=' . config('constants.apiKey') . '&display=full&output_format=JSON';
    //     $response = $this->http->get($full_path, [
    //         'headers'         => $this->headers,
    //         'timeout'         => 100,
    //         'connect_timeout' => true,
    //         'http_errors'     => true,
    //     ]);
    //     $res = json_decode($response->getBody(), true);
    //     $category = collect($res['categories'])->filter(function ($value) {
    //         return $value['id_parent'] == '2';
    //     });
    //     return $category;
    // }

    public function addCart($productoId)
    {
        $idCustomer = session('idCustomer');

        \Cart::session($idCustomer)->add(array(
            'id' => 1,
            'name' => 'asdas',
            'price' => 11,
            'quantity' => 4,
            'attributes' => array(),
            'associatedModel' => 11
        ));

        $items = \Cart::getContent();
        
        $xml = $this->prestashop->get([
            'resource' => 'customers',
            'id' => 1, // Here we use hard coded value but of course you could get this ID from a request parameter or anywhere else
        ]);
        return  null;
    }

    public function getCart()
    {
    }

    public function deleteCart()
    {
    }

    public function updateCart()
    {
    }
}
