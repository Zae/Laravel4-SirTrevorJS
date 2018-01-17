<?php
/**
 * Laravel-SirTrevorJs.
 *
 * @link https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs;

use Illuminate\Support\ServiceProvider;
use View;

/**
 * Sir Trevor Js service provider.
 */
class SirtrevorjsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        include __DIR__.'/../../routes.php';

        $this->loadViewsFrom(__DIR__.'/../../views/', 'sirtrevorjs');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        //
    }
}
