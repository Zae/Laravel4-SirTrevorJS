<?php

declare(strict_types=1);

namespace Caouecs\Tests\Unit;

/**
 * Class TestCase
 *
 * @package Caouecs\Tests\Unit
 */
abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return ['Caouecs\Sirtrevorjs\SirtrevorjsServiceProvider'];
    }
}
