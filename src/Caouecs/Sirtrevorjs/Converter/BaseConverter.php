<?php

declare(strict_types=1);

/**
 * Laravel-SirTrevorJs.
 *
 * @link https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Converter;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

use function in_array;

/**
 * Base of converters for Sir Trevor Js.
 */
abstract class BaseConverter
{
    /**
     * Config of Sir Trevor Js.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Type of block.
     *
     * @var string
     */
    protected $type = '';

    /**
     * Data of block.
     *
     * @var array
     */
    protected $data = [];

    /** @var string[] */
    protected $types = [];

    /**
     * Construct.
     *
     * @param array $config Config of Sir Trevor Js
     * @param array $data   Data of element
     */
    public function __construct(array $config, array $data)
    {
        $this->type = Arr::get($data, 'type');
        $this->data = Arr::get($data, 'data');

        $this->config = $config;
    }

    /**
     * Render.
     *
     * @param array $codejs Array with JS for Sir Trevor Js
     *
     * @return string
     */
    public function render(array &$codejs): string
    {
        if (in_array($this->type, $this->types, true)) {
            $method = Str::camel($this->type) . 'ToHtml';

            return (string)$this->$method($codejs);
        }

        return '';
    }

    /**
     * Personalized views.
     *
     * @param string $viewName Name of the base view
     * @param array  $params   Params
     *
     * @return View
     */
    public function view(string $viewName, array $params = []): View
    {
        if (isset($this->config['view']) && view()->exists($this->config['view'] . '.' . $viewName)) {
            return view()->make($this->config['view'] . '.' . $viewName, $params);
        }

        return view()->make('sirtrevorjs::' . $viewName, $params);
    }
}
