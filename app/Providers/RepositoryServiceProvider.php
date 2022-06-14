<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
//base
use App\Repositories\Eloquent\BaseRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;
//Vehicles
use App\Repositories\Eloquent\Vehicles\Interfaces\VehicleRepositoryInterface;
use App\Repositories\Eloquent\Vehicles\VehicleRepository;
//vehicle category
use App\Repositories\Eloquent\Vehicles\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Eloquent\Vehicles\CategoryRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //bind interface with the repository
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(VehicleRepositoryInterface::class, VehicleRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        

    }
}
