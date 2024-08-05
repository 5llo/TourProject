<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\Designer;
use App\Models\Global_info;
use App\Models\Offer;
use App\Models\Service;
use App\Models\Tour;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    Relation::MorphMap([
      'Offer' => Offer::class,
      'Customer' => Customer::class,
      'Designer'=>Designer::class,
      'Info'=>Global_info::class,
      'Service'=>Service::class,
      'Tour'=>Tour::class,
]);
    }
}
