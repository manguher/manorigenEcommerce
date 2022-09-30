<?php

namespace App\Providers;

use App\Services\Implement\CategoryRepo;
use App\Services\Interfaces\CategoryInterface;
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
