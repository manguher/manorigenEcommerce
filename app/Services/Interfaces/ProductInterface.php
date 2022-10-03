<?php

namespace App\Services\Interfaces;

interface ProductInterface
{
    public function getAllProducts();
    public function getProductsByCategoryId($categoryId);
    public function getProductsById($productId);
}