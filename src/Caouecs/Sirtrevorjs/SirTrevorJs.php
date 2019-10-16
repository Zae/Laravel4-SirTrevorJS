<?php
declare(strict_types=1);

/**
 * Laravel-SirTrevorJs.
 *
 * @link https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs;

use function is_array;

/**
 * Sir Trevor Js.
 */
class SirTrevorJs
{
    /**
     * Textarea class.
     *
     * @var string
     * @static
     */
    protected static $class = 'sir-trevor';

    /**
     * Block types.
     *
     * @var string
     * @static
     */
    protected static $blocktypes = ['Text', 'List', 'Quote', 'Image', 'Video', 'Tweet', 'Heading'];

    /**
     * Language of Sir Trevor JS.
     *
     * @var string
     * @static
     */
    protected static $language = 'en';

    /**
     * Upload url for images.
     *
     * @var string
     * @static
     */
    protected static $uploadUrl = '/sirtrevorjs/upload';

    /**
     * Url for tweets.
     *
     * @var string
     * @static
     */
    protected static $tweetUrl = '/sirtrevorjs/tweet';

    /**
     * Transform text with image bug.
     *
     * @param string $txt Text to fix
     *
     * @return string
     * @static
     */
    public static function transformText($txt): string
    {
        $txt = json_decode($txt, true);

        $return = null;

        if (is_array($txt) && isset($txt['data'])) {
            foreach ($txt['data'] as $data) {
                /*
                 * The bug is with new image, the data is in an array where each character is an element of this array
                 *
                 * This code transforms this array into a string (JSON format)
                 * and after it transforms it into an another array for Sir Trevor
                 */
                if ($data['type'] === 'image' && !isset($data['data']['file'])) {
                    $return[] = [
                        'type' => 'image',
                        'data' => json_decode(implode($data['data']), true),
                    ];
                } else {
                    $return[] = $data;
                }
            }

            return json_encode(['data' => $return], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        return '';
    }

    /**
     * Stylesheet files
     *   see config file.
     *
     * @return string
     * @static
     */
    public static function stylesheets(): string
    {
        // params in config file
        $config = config()->get('sirtrevorjs::sir-trevor-js');

        /*
         * Files of Sir Trevor JS
         */
        $return = Html::style($config['path'] . 'sir-trevor-icons.css')
            .Html::style($config['path'] . 'sir-trevor.css');

        /*
         * Others files if you need it
         */
        if (isset($config['stylesheet']) && is_array($config['stylesheet'])) {
            foreach ($config['stylesheet'] as $arr) {
                if (file_exists(public_path($arr))) {
                    $return .= Html::style($arr);
                }
            }
        }

        return $return;
    }

    /**
     * Javascript files.
     *
     * @param array $params
     *
     * @return string
     * @static
     *
     * Params :
     * - class
     * - blocktypes
     * - language
     * - uploadUrl
     * - tweetUrl
     */
    public static function scripts(array $params = []): string
    {
        // params
        $config = self::config($params);
        $return = null;

        /*
         * Others files
         */
        if (isset($config['script']) && is_array($config['script'])) {
            foreach ($config['script'] as $arr) {
                if (file_exists(public_path($arr))) {
                    $return .= Html::script($arr);
                }
            }
        }
        /*
         * File of Sir Trevor JS
         */
        $return .= Html::script($config['path'] . 'sir-trevor.min.js')
            .Html::script($config['path'] . 'locales/' . $config['language'] . ".js");

        return $return . view()->make('sirtrevorjs::js', ['config' => $config]);
    }

    /**
     * Configuration of Sir Trevor JS.
     *
     * 1 - $params
     * 2 - config file
     * 3 - default
     *
     * @param array $params Personalized params
     *
     * @return array
     * @static
     */
    public static function config($params = null): array
    {
        // params in config file
        $config = config()->get('sirtrevorjs::sir-trevor-js');

        /*
         * Block types
         */
        // params
        if (isset($params['blocktypes']) && !empty($params['blocktypes']) && is_array($params['blocktypes'])) {
            $blocktypes = $params['blocktypes'];
        // config
        } elseif (isset($config['blocktypes']) && !empty($config['blocktypes']) && is_array($config['blocktypes'])) {
            $blocktypes = $config['blocktypes'];
        // default
        } else {
            $blocktypes = self::$blocktypes;
        }

        return [
            'path'          => $config['path'],
            'script'        => $config['script'],
            'blocktypes'    => "'" . implode("', '", $blocktypes) . "'",
            'class'         => self::defineParam('class', $params),
            'language'      => self::defineParam('language', $params, $config),
            'uploadUrl'     => self::defineParam('uploadUrl', $params, $config),
            'tweetUrl'      => self::defineParam('tweetUrl', $params, $config),
        ];
    }

    /**
     * Define param.
     *
     * @param string $type
     * @param array  $params
     * @param array  $config
     *
     * @return string
     */
    private static function defineParam($type, $params, $config = []): string
    {
        if (isset($params[$type]) && !empty($params[$type])) {
            return $params[$type];
        }

        if (isset($config[$type]) && !empty($config[$type])) {
            return $config[$type];
        }

        // default
        return self::$$type;
    }

    /**
     * Convert json from Sir Trevor JS to html.
     *
     * @param string $text
     *
     * @return string
     * @static
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function render($text): string
    {
        $converter = app()->make(SirTrevorJsConverter::class);

        return $converter->toHtml($text);
    }

    /**
     * Find first image in text from Sir Trevor JS.
     *
     * @param string $text
     *
     * @return string Url of image
     * @static
     */
    public static function findImage($text): string
    {
        $array = json_decode($text, true);

        if (!isset($array['data'])) {
            return '';
        }

        foreach ($array['data'] as $arr) {
            if ($arr['type'] === 'image' && isset($arr['data']['file']['url'])) {
                return $arr['data']['file']['url'];
            }
        }

        return '';
    }

    /**
     * Find occurences of a type of block in a text.
     *
     * @param string $text
     * @param string $blocktype
     * @param string $output    json or array
     * @param int    $nbr       Number of occurences ( 0 = all )
     *
     * @return array | boolean Returns list of blocks in an array if exists. Else, returns false
     * @static
     */
    public static function find($text, $blocktype, $output = "json", $nbr = 0)
    {
        $array = json_decode($text, true);

        if ((int)$nbr === 0 || !isset($array['data'])) {
            return;
        }

        $return = null;
        $_nbr = 1;

        foreach ($array['data'] as $arr) {
            if ($arr['type'] === $blocktype) {
                $return[] = $arr['data'];

                if ($_nbr === $nbr) {
                    break;
                }

                $_nbr++;
            }
        }

        if (empty($return) || $output === 'array') {
            return $return;
        }

        return json_encode($return, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * Find first occurence of a type of block in a text.
     *
     * @param string $text
     * @param string $blocktype
     * @param string $output    json or array
     *
     * @return array | boolean Returns list of blocks in an array if exists. Else, returns false
     * @static
     */
    public static function first($text, $blocktype, $output = "json")
    {
        return static::find($text, $blocktype, $output, 1);
    }
}
