<?php
/**
 * Laravel4-SirTrevorJs
 *
 * @link https://github.com/caouecs/Laravel4-SirTrevorJS
 */

namespace Caouecs\Sirtrevorjs\Converter;

/**
 * Modelisation for Sir Trevor Js
 *
 * @package Caouecs\Sirtrevorjs\Converter
 */
class ModelisationConverter extends BaseConverter
{
    /**
     * List of types for modelisation
     *
     * @access protected
     * @var array
     */
    protected $types = array(
        "sketchfab"
    );

    /**
     * Sketchfab block
     *
     * @access public
     * @return string
     */
    public function sketchfabToHtml()
    {
        return $this->view("modelisation.sketchfab", array(
            "remote_id" => $this->data['remote_id']
        ));
    }
}
