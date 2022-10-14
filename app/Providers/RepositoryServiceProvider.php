<?php

namespace App\Providers;

use App\Services\Implement\CategoryRepo;
use App\Services\Interfaces\CategoryInterface;
use App\Services\Interfaces\CartInterface;
use App\Services\Implement\CartRepo;
use App\Services\Implement\ProductsRepo;
use App\Services\Interfaces\ProductInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CategoryInterface::class, CategoryRepo::class);
        $this->app->bind(ProductInterface::class, ProductsRepo::class);
        $this->app->bind(CartInterface::class, CartRepo::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
