<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        config(['WSSinproc' => 'http://dev.personeriabogota.gov.co/sinproc_P1/config/00_wssinproc/']);
        config(['LogoutSinproc' => 'http://dev.personeriabogota.gov.co/sinproc_P1/config/cerrar_session.php']);
        config(['ModMp' => 'http://mp.test/']);
    }
}
