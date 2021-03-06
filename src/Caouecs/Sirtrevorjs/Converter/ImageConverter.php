<?php
/**
 * Laravel4-SirTrevorJs
 *
 * @link https://github.com/caouecs/Laravel4-SirTrevorJS
 */

namespace Caouecs\Sirtrevorjs\Converter;

use Caouecs\Sirtrevorjs\Contracts\ConverterInterface;

/**
 * Images for Sir Trevor Js
 *
 * @package Caouecs\Sirtrevorjs\Converter
 */
class ImageConverter extends BaseConverter implements ConverterInterface
{
    /**
     * List of types
     *
     * @access protected
     * @var array
     */
    protected $types = array(
        "image",
        "gettyimages",
        "pinterest"
    );

    /**
     * Converts the image to html
     *
     * @access public
     * @return string
     */
    public function imageToHtml()
    {
        if (is_null(array_get($this->data, 'file.url'))) {
            return null;
        }

        return $this->view("image.image", array(
            "url" => array_get($this->data, 'file.url'),
            "text" => array_get($this->data, 'text')
        ));
    }

    /**
     * Converts GettyImage to html
     *
     * @access public
     * @return string
     */
    public function gettyimagesToHtml()
    {
        return $this->view("image.gettyimages", array(
            "remote_id" => $this->data['remote_id'],
            "width" => array_get($this->config, 'gettyimages.width', 594),
            "height" => array_get($this->config, 'gettyimages.height', 465)
        ));
    }

    /**
     * Converts Pinterest to html
     *
     * @access public
     * @param array $codejs Array of js
     * @return string
     */
    public function pinterestToHtml(&$codejs)
    {
        /**
         * Pin
         */
        if ($this->data['provider'] === "pin") {
            $codejs['pin'] = '<script type="text/javascript" async src="//assets.pinterest.com/js/pinit.js">'
                .'</script>';

            return $this->view("image.pin", array(
                "remote_id" => $this->data['remote_id'])
            );
        }

        return null;
    }
}
