<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Article\Providers\ArticleProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(ArticleProvider::class);
    }

    public function boot(): void
    {
        //
    }
}
