<?php

namespace App\Providers;

use App\Models\OpdConfigs;
use App\Policies\RolePolicy;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        //
        View::composer('*', function ($view) {

            $opdId = session('current_opd_id'); // atau logic lain jika multisite
            $opdConfigs = null;

            if ($opdId) {
                $opdConfigs = OpdConfigs::where('opd_id', $opdId)->first();
            }

            $view->with('opdConfigs', $opdConfigs);
        });
    }
}
