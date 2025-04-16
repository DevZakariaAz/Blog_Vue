<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\App\Providers\CoreServiceProvider;
use Modules\PkgBlog\App\Providers\PkgBlogServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(CoreServiceProvider::class);
        $this->app->register(PkgBlogServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
