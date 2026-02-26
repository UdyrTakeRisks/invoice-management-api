<?php

namespace App\Providers;

use App\Actions\TaxCalculators\MunicipalFeeTaxCalculator;
use App\Actions\TaxCalculators\VATTaxCalculator;
use App\Interfaces\TaxCalculatorInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Services\TaxService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->bindRepositoryInterface();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    private function bindRepositoryInterface()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(TaxCalculatorInterface::class, function ($app) {
            return [
                // Resolve the given types
                $app->make(VATTaxCalculator::class),
                $app->make(MunicipalFeeTaxCalculator::class),
            ];
        });
        // another way injects the array with objects when needed
        // $this->app->when(TaxService::class)
        //           ->needs('$taxCalculators')
        //           ->give(function ($app) {
        //             return [
        //                 $app->make(VATTaxCalculator::class),
        //                 $app->make(MunicipalFeeTaxCalculator::class),
        //             ];
        //           });

    }
}
