<?php
declare(strict_types=1);

/**
 * Laravel-SirTrevorJs.
 *
 * @link https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs;

use Illuminate\Support\ServiceProvider;

/**
 * Sir Trevor Js service provider.
 */
class SirtrevorjsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '../../config/sir-trevor-js.php' => config_path('sirtrevorjs.php'),
        ]);
        $this->mergeConfigFrom(__DIR__ . '../..//config/sir-trevor-js.php', 'sirtrevorjs');
        $this->loadRoutesFrom(__DIR__ . '/../../routes.php');
        $this->loadViewsFrom(__DIR__ . '/../../views/', 'sirtrevorjs');
        $this->publishes([
            __DIR__ . '/../../views' => resource_path('views/vendor/sirtrevorjs'),
        ]);
    }
}
