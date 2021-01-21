<?php
declare(strict_types=1);

/**
 * Laravel-SirTrevorJs.
 *
 * @link https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Contracts;

/**
 * Interface ConverterInterface.
 */
interface ConverterInterface
{
    /**
     * @param array $codejs
     *
     * @return string
     */
    public function render(array &$codejs): string;
}
