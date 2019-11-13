<?php
declare(strict_types=1);

/**
 * Laravel-SirTrevorJs.
 *
 * @link https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs;

use Illuminate\Config\Repository;
use function array_key_exists;
use function is_array;

/**
 * Class Converter.
 *
 * A Sir Trevor to HTML conversion helper for PHP
 * inspired by work of Wouter Sioen <info@woutersioen.be>
 */
class SirTrevorJsConverter
{
    /**
     * Valid blocks with converter.
     *
     * @var array
     */
    protected $blocks = [
        'blockquote'    => 'Text',
        'embedly'       => 'Embedly',
        'facebook'      => 'Social',
        'gettyimages'   => 'Image',
        'heading'       => 'Text',
        'image'         => 'Image',
        'issuu'         => 'Presentation',
        'markdown'      => 'Text',
        'pinterest'     => 'Image',
        'quote'         => 'Text',
        'sketchfab'     => 'Modelisation',
        'slideshare'    => 'Presentation',
        'soundcloud'    => 'Sound',
        'spotify'       => 'Sound',
        'text'          => 'Text',
        'video'         => 'Video',
        'list'          => 'Text',
        'image_caption' => 'ImageCaption',
    ];

    /**
     * @var mixed
     */
    private $config;

    /**
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config->get('sir-trevor-js');
    }

    /**
     * Converts the outputted json from Sir Trevor to html.
     *
     * @param string $json
     *
     * @return string
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function toHtml(?string $json): string
    {
        if ($json === null) {
            return '';
        }

        // convert the json to an associative array
        $input = json_decode($json, true);
        $html  = '';
        $codejs = null;

        if (is_array($input)) {
            // loop trough the data blocks
            foreach ($input['data'] as $block) {
                // no data, problem
                if (!isset($block['data']) || !array_key_exists($block['type'], $this->blocks)) {
                    break;
                }

                $class = "Caouecs\\Sirtrevorjs\\Converter\\" . $this->blocks[$block['type']] . 'Converter';

                $converter = app()->make($class, [
                    'config' => $this->config,
                    'data' => $block
                ]);

                $html .= $converter->render($codejs);
            }

            // code js
            if (is_array($codejs)) {
                $html .= implode($codejs);
            }
        }

        return $html;
    }
}
