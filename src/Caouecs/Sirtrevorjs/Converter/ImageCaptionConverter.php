<?php
/**
 * Laravel-SirTrevorJs.
 *
 * @link https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Converter;

use Caouecs\Sirtrevorjs\Contracts\ConverterInterface;

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
        "image",
        "gettyimages",
        "pinterest",
        "image_caption"
    ];

    /**
     * Converts the image to html.
     *
     * @return string
     */
    public function image_captionToHtml()
    {
        if (is_null(array_get($this->data, 'file.url'))) {
            return;
        }

        return $this->view("image.image", [
            "url"  => array_get($this->data, 'file.url'),
            "text" => array_get($this->data, 'text'),
        ]);
    }
}
