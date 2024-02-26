<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
        $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
        $this->app->register(TelescopeServiceProvider::class);
    }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();

        Gate::define('sekretaris', function (User $user) {
            return $user->is_sekma == true || $user->is_sekwil == true;
        });

        Gate::define('inspektur', function (User $user) {
            return $user->is_aktif == true;
        });

        Gate::define('analis_sdm', function (User $user) {
            return $user->is_analissdm == true;
        });
        Gate::define('admin', function (User $user) {
            return $user->is_admin == true;
        });
        Gate::define('perencana', function (User $user) {
            return $user->is_perencana == true;
        });
    }
}
