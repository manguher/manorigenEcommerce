<?php
namespace App\Services\Interfaces;

interface OrderInterface
{
    public function createOrder($order);
    public function updateOrder($order);
    
}