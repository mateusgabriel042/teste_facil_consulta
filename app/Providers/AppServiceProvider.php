<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

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
        date_default_timezone_set('America/Sao_Paulo');
        Schema::defaultStringLength(191);
        Validator::extend('cpf', '\App\Util\Validations@validateCPF');
        Validator::extend('cnpj', '\App\Util\Validations@validateCNPJ');
    }
}
