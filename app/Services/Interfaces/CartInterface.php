<?php
namespace App\Services\Interfaces;

interface CartInterface
{
    public function getCart();
    public function deleteItem($idProducto);
    public function updateCart($idProducto, $quantity);
    public function addCart($idProducto);
}