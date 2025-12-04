<?php

namespace App\Providers;

use App\Models\OpdConfigs;
use App\Policies\RolePolicy;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // override public path untuk asset vite
        // ini adalah untuk chield
        // Vite::useBuildDirectory('build');

        // app()->bind('path.public', function () {
        //     return base_path('public');
        // });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        View::composer('*', function ($view) {

            $opdId = session('current_opd_id'); // atau logic lain jika multisite
            $opdConfigs = null;

            if ($opdId) {
                $opdConfigs = OpdConfigs::where('opd_id', $opdId)->first();
            }

            $view->with('opdConfigs', $opdConfigs);
        });

        // Mendaftarkan semua entry points yang akan digunakan di seluruh aplikasi
        Vite::withEntryPoints([
            'resources/css/app.css',
            'resources/js/app.js',
        ]);

        app()->singleton('current_opd', function () {
            return env('APP_ID');
        });


        // $css_url = Vite::asset('resources/css/app.css');
    }
}
