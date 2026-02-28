<?php

namespace App\Providers;

use App\Actions\TaxCalculators\MunicipalFeeTaxCalculator;
use App\Actions\TaxCalculators\VATTaxCalculator;
use App\Interfaces\ContractRepositoryInterface;
use App\Interfaces\InvoiceRepositoryInterface;
use App\Interfaces\PaymentRepositoryInterface;
use App\Interfaces\TaxCalculatorInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\Invoice;
use App\Models\Payment;
use App\Observers\InvoiceObserver;
use App\Observers\PaymentObserver;
use App\Repositories\CachingInvoiceRepository;
use App\Repositories\ContractRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\UserRepository;
use App\Services\TaxService;
use Illuminate\Foundation\Application;
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
        $this->bindObserver();
    }

    private function bindRepositoryInterface()
    {
        $this->app->bind(ContractRepositoryInterface::class, ContractRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        
        // laracast reference: https://laracasts.com/discuss/channels/laravel/repository-pattern-with-caching-laravel
        // Caching layer using Decorator Pattern
        $this->app->bind(InvoiceRepositoryInterface::class, function () {
            return new CachingInvoiceRepository(
                new InvoiceRepository()
            );
        });

        // laravel doc reference: https://laravel.com/docs/10.x/container#binding-typed-variadics
        // dependency injects an array with concrete class names when needed
        $this->app->when(TaxService::class)
            ->needs(TaxCalculatorInterface::class)
            ->give([
                VATTaxCalculator::class,
                MunicipalFeeTaxCalculator::class,
            ]);

    }

    private function bindObserver()
    {
        Invoice::observe(InvoiceObserver::class);
        Payment::observe(PaymentObserver::class);
    }
}