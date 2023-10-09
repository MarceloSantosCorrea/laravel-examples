<?php

namespace App\Providers;

use App\Services\Facebook\FacebookPersistentDataHandler;
use App\Services\Repositories\TodoRepository;
use Core\Todo\Application\Repository\TodoRepositoryInterface;
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Facebook\Facebook;
use Illuminate\Routing\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            TodoRepositoryInterface::class,
            TodoRepository::class,
        );

        $this->app->bind(Facebook::class, function () {
            return new Facebook([
                'app_id' => config('services.facebook.app_id'),
                'app_secret' => config('services.facebook.app_secret'),
                'default_graph_version' => 'v13.0',
                'persistent_data_handler' => new FacebookPersistentDataHandler(),
            ]);
        });
    }

    public function boot(): void
    {
        Scramble::routes(function (Route $route) {
            return Str::startsWith($route->uri, 'api/');
        });

        Scramble::extendOpenApi(function (OpenApi $openApi) {
            $openApi->secure(
                SecurityScheme::http('bearer', 'JWT')
            );
        });
    }
}
