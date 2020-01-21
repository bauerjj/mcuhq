<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Webuni\CommonMark\TableExtension\TableExtension;
use League\CommonMark\Environment;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->resolving('markdown.environment', function (Environment $environment) {
            $environment->addExtension(new TableExtension());
        });
    }
}
