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
use Illuminate\Contracts\View\View;

/**
 * Images for Sir Trevor Js.
 */
class ImageConverter extends BaseConverter implements ConverterInterface
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
    ];

    /**
     * Converts the image to html.
     *
     * @return string|View
     */
    public function imageToHtml()
    {
        if (Arr::get($this->data, 'file.url') === null) {
            return '';
        }

        return $this->view('image.image', [
            'url'   => Arr::get($this->data, 'file.url'),
            'text'  => Arr::get($this->data, 'text'),
        ]);
    }

    /**
     * Converts GettyImage to html.
     *
     * @return string|View
     */
    public function gettyimagesToHtml()
    {
        return $this->view('image.gettyimages', [
            'remote_id' => $this->data['remote_id'],
            'width'     => Arr::get($this->config, 'gettyimages.width', 594),
            'height'    => Arr::get($this->config, 'gettyimages.height', 465),
        ]);
    }

    /**
     * Converts Pinterest to html.
     *
     * @param array $codejs Array of js
     *
     * @return string|View
     */
    public function pinterestToHtml(array &$codejs)
    {
        if ($this->data['provider'] === 'pin') {
            $codejs['pin'] = '<script type="text/javascript" async src="//assets.pinterest.com/js/pinit.js">'
                .'</script>';

            return $this->view('image.pin', [
                'remote_id' => $this->data['remote_id'] ?? null,
            ]);
        }

        return '';
    }
}
