<?php
namespace Modules\Article\Providers;

use Illuminate\Support\ServiceProvider;

class ArticleProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
   
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php', 'api');

    }
}
