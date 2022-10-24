<?php
namespace App\Services\Interfaces;

interface CartInterface
{
    public function getCart();
    public function deleteItem($idProducto);
    public function updateCart($idProducto, $cantidad);
    public function addCart($idProducto);
}