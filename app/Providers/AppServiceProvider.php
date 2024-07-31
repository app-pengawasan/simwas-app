<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\URL;
use App\View\Composers\SidebarAdmin;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use App\View\Composers\SidebarPegawai;
use Illuminate\Support\ServiceProvider;
use App\View\Composers\SidebarPerencana;
use App\View\Composers\SidebarSekretaris;

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

        // force to use https
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

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
        Gate::define('arsiparis', function (User $user) {
            return $user->is_arsiparis == true;
        });

        Facades\View::composer(
            'components.sekretaris-sidebar', SidebarSekretaris::class,
        );
        Facades\View::composer(
            'components.pegawai-sidebar', SidebarPegawai::class,
        );
        Facades\View::composer(
            'components.admin-sidebar', SidebarAdmin::class,
        );
        Facades\View::composer(
            'components.perencana-sidebar', SidebarPerencana::class,
        );
    }
}
