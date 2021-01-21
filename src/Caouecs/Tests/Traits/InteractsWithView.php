<?php

declare(strict_types=1);

namespace Caouecs\Tests\Traits;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;

use function is_array;
use function is_int;
use function is_null;

/**
 * Trait InteractsWithView
 *
 * @package Caouecs\Tests\Traits
 */
trait InteractsWithView
{
    /**
     * Assert that the response view has a given piece of bound data.
     *
     * @param View         $view
     * @param string|array $key
     * @param mixed        $value
     */
    public static function assertViewHas(View $view, $key, $value = null): void
    {
        if (is_array($key)) {
            static::assertViewHasAll($view, $key);

            return;
        }

        if (is_null($value)) {
            static::assertTrue(Arr::has($view->gatherData(), $key));
        } else {
            static::assertEquals($value, Arr::get($view->gatherData(), $key));
        }
    }

    /**
     * Assert that the response view has a given list of bound data.
     *
     * @param View  $view
     * @param array $bindings
     */
    public static function assertViewHasAll(View $view, array $bindings): void
    {
        foreach ($bindings as $key => $value) {
            if (is_int($key)) {
                static::assertViewHas($view, $value);
            } else {
                static::assertViewHas($view, $key, $value);
            }
        }
    }
}
