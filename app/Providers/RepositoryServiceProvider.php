<?php

namespace App\Providers;

use App\Services\Implement\OrderRepo;
use App\Services\Interfaces\OrderInterface;
use App\Services\Implement\CategoryRepo;
use App\Services\Interfaces\CategoryInterface;
use App\Services\Interfaces\CartInterface;
use App\Services\Implement\CartRepo;
use App\Services\Implement\ProductsRepo;
use App\Services\Interfaces\CityInterface;
use App\Services\Implement\CityRepo;
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
        $this->app->bind(OrderInterface::class, OrderRepo::class);
        $this->app->bind(CityInterface::class, CityRepo::class);
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
