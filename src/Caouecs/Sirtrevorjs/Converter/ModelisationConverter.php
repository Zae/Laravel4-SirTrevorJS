<?php
declare(strict_types=1);

/**
 * Laravel-SirTrevorJs.
 *
 * @link https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Converter;

use Caouecs\Sirtrevorjs\Contracts\ConverterInterface;
use Illuminate\Contracts\View\View;

/**
 * Modelisation for Sir Trevor Js.
 */
class ModelisationConverter extends BaseConverter implements ConverterInterface
{
    /**
     * List of types for modelisation.
     *
     * @var array
     */
    protected $types = [
        'sketchfab',
    ];

    /**
     * Sketchfab block.
     *
     * @return View
     */
    public function sketchfabToHtml(): View
    {
        return $this->view('modelisation.sketchfab', [
            'remote_id' => $this->data['remote_id'] ?? null,
        ]);
    }
}
