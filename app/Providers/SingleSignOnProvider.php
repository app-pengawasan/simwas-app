<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Facades\Socialite;
use JKD\SSO\Client\Provider\Keycloak as KeycloakProviderSSO;
use Illuminate\Support\Facades\Log;

class SingleSignOnProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(KeycloakProviderSSO::class, function ($app) {
        return new KeycloakProviderSSO([
        'authServerUrl'         => env('SSO_AUTH_SERVER_URL'),
        'realm'                 => env('SSO_REALM'),
        'clientId'              => env('SSO_CLIENT_ID'),
        'clientSecret'          => env('SSO_CLIENT_SECRET'),
        'redirectUri'           => env('SSO_REDIRECT_URI')
        ]);
    });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
{
    $this->app->singleton(KeycloakProviderSSO::class, function ($app) {
        return new KeycloakProviderSSO([
        'authServerUrl'         => env('SSO_AUTH_SERVER_URL'),
        'realm'                 => env('SSO_REALM'),
        'clientId'              => env('SSO_CLIENT_ID'),
        'clientSecret'          => env('SSO_CLIENT_SECRET'),
        'redirectUri'           => env('SSO_REDIRECT_URI')
        ]);
    });
}
}
