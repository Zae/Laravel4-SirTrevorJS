<?php
declare(strict_types=1);

/**
 * Laravel-SirTrevorJs.
 *
 * @link https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Converter;

use Caouecs\Sirtrevorjs\Contracts\ConverterInterface;
use Illuminate\Support\Arr;

/**
 * Images for Sir Trevor Js.
 */
class ImageCaptionConverter extends ImageConverter implements ConverterInterface
{
    /**
     * List of types.
     *
     * @var array
     */
    protected $types = [
        'image',
        'gettyimages',
        'pinterest',
        'image_caption'
    ];

    /**
     * Converts the image to html.
     *
     * @return string|\Illuminate\Contracts\View\View
     */
    public function imageCaptionToHtml()
    {
        if (Arr::get($this->data, 'file.url') === null) {
            return '';
        }

        return $this->view('image.image', [
            'url'   => Arr::get($this->data, 'file.url'),
            'text'  => Arr::get($this->data, 'text'),
        ]);
    }
}
