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
 * Sound for Sir Trevor Js.
 */
class SoundConverter extends BaseConverter implements ConverterInterface
{
    /**
     * List of types for sound.
     *
     * @var string[]
     */
    protected $types = [
        'soundcloud',
        'spotify',
    ];

    /**
     * Soundcloud block.
     *
     * @return View
     */
    public function soundcloudToHtml(): View
    {
        $theme = (isset($this->config['soundcloud']) && $this->config['soundcloud'] === 'full') ? 'full' : 'small';

        return $this->view('sound.soundcloud.' . $theme, [
            'remote' => $this->data['remote_id'] ?? null,
        ]);
    }

    /**
     * Spotify block.
     *
     * @return View
     */
    public function spotifyToHtml(): View
    {
        return $this->view('sound.spotify', [
            'remote'    => $this->data['remote_id'] ?? null,
            'options'   => $this->config['spotify'] ?? null,
        ]);
    }
}
