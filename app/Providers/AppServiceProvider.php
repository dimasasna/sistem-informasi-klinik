<?php

namespace App\Providers;

use App\Models\Payment;
use App\Models\Kunjungan;
use App\Models\VisitObat;
use App\Models\VisitTindakan;
use App\Observers\PaymentObserver;
use App\Observers\KunjunganObserver;
use App\Observers\VisitObatObserver;
use Illuminate\Support\ServiceProvider;
use App\Observers\VisitTindakanObserver;

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
        Payment::observe(PaymentObserver::class);
        Kunjungan::observe(KunjunganObserver::class);
        VisitTindakan::observe(VisitTindakanObserver::class);
        VisitObat::observe(VisitObatObserver::class);
    }
}
