<?php

namespace App\Services\Implement;

use App\Services\Interfaces\CartInterface;
use Darryldecode\Cart\Cart;
use GuzzleHttp\Client;
use Protechstudio\PrestashopWebService\PrestashopWebService;
use App\Services\Interfaces\CategoryInterface;
use App\Services\Interfaces\ProductInterface;

class CartRepo implements CartInterface
{
    protected $url;
    protected $http;
    protected $headers;
    private $prestashop;
    private ProductInterface $productInterface;

    public function __construct(Client $client, PrestashopWebService $prestashop, ProductInterface $productInterface)
    {
        $this->url = config('constants.apiUrl');
        $this->http = $client;
        $this->headers = [
            'cache-control' => 'no-cache',
            'content-type' => 'application/x-www-form-urlencoded',
        ];
        $this->productInterface = $productInterface;
        $this->prestashop = $prestashop;
    }

    public function addCart($productId)
    {
        $idCustomer = session('idCustomer');
        $product = $this->productInterface->getProductsById($productId);
        // $name = $product['products'][0]['name'];
        // $price = (float)$product['products'][0]['price'];

        \Cart::add(array(
            'id' => $productId, // inique row ID
            'name' => $product['products'][0]['name'],
            'price' => (float)$product['products'][0]['price'],
            'quantity' => 1,
            'attributes' => array()
        ));
        return  count(\Cart::getContent());
    }

    public function getCart()
    {
        // foreach($items as $row) {

        // 	echo $row->id; // row ID
        // 	echo $row->name;
        // 	echo $row->qty;
        // 	echo $row->price;

        // 	echo $item->associatedModel->id; // whatever properties your model have
        //         echo $item->associatedModel->name; // whatever properties your model have
        //         echo $item->associatedModel->description; // whatever properties your model have
        // }
        $items = \Cart::getContent();
        return \Cart::getContent();
    }

    public function deleteItem($idProduct)
    {
        \Cart::remove($idProduct);
        return  count(\Cart::getContent());
    }

    public function updateCart($idProductom, $cantidad)
    {
        // Cart::update($idProducto, array(
        //     'name' => 'New Item Name', // new item name
        //     'price' => 98.67, // new item price, price can also be a string format like so: '98.67'
        //   ));
    }
}
