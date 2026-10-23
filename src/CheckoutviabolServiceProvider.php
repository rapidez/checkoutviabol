<?php

namespace Rapidez\Checkoutviabol;

use Illuminate\Support\ServiceProvider;
use TorMorten\Eventy\Facades\Eventy;

class CheckoutviabolServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this
            ->bootRoutes()
            ->bootPublishables()
            ->bootFilters();
    }

    public function bootRoutes(): self
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        return $this;
    }

    public function bootPublishables(): self
    {
        $this->publishes([
            __DIR__ . '/../resources/payment-icons' => public_path('payment-icons'),
        ], 'payment-icons');

        return $this;
    }

    public function bootFilters(): self
    {
        Eventy::addFilter('checkout.queries.orderV2.data', function ($attributes = []) {
            $attributes[] = 'cvb_redirect_url';

            return $attributes;
        });

        return $this;
    }
}
