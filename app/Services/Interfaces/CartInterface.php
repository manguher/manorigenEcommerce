<?php
namespace App\Services\Interfaces;

interface CartInterface
{
    public function getCart();
    public function deleteCart();
    public function updateCart();
    public function addCart($idProducto);
}