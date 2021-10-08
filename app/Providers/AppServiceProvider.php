<?php

namespace App\Providers;

use App\Http\Resources\UserResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        //
        setlocale(LC_TIME, 'French');
        Carbon::setLocale('fr');
        ResourceCollection::withoutWrapping();
    }
}
