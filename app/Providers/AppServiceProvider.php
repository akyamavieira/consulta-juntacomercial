<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use App\Services\EventosService;
use App\Services\EstabelecimentoService;
use App\Services\ApiService; // Add this
use App\Repository\EstabelecimentoRepository; // Add this
use App\Handlers\RateLimitHandler; // Add this

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Registrar o EventosService como um singleton no container
        $this->app->singleton(EventosService::class, function ($app) {
            return new EventosService();
        });

        // Registrar o EstabelecimentoService com suas dependências
        $this->app->singleton(EstabelecimentoService::class, function ($app) {
            return new EstabelecimentoService(
                $app->make(ApiService::class), // Resolve ApiService
                $app->make(EstabelecimentoRepository::class), // Resolve EstabelecimentoRepository
                $app->make(RateLimitHandler::class) // Resolve RateLimitHandler
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }

        Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
            $event->extendSocialite('keycloak', \SocialiteProviders\Keycloak\Provider::class);
        });
    }
}