<?php

namespace App\Providers;

use App\Providers\ServiceProvider;

class ErrorMiddlewareServiceProvider extends ServiceProvider{


    public function register()
    {
        if(env('APP_DEBUG')){
            $this->app->addErrorMiddleware(
                config('middleware.error_details.displayErrorDetails'),
                config('middleware.error_details.logErrors'),
                config('middleware.error_details.logErrorDetails'),
            );
        }
    }

    public function boot(){

    }
}