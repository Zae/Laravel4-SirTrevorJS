<?php

declare(strict_types=1);

namespace Caouecs\Tests\Unit\Converter;

use Caouecs\Sirtrevorjs\Converter\ImageConverter;
use Caouecs\Tests\Traits\InteractsWithView;
use Caouecs\Tests\Unit\TestCase;

/**
 * Class ImageConverterTest
 *
 * @package Caouecs\Tests\Unit\Converter
 */
class ImageConverterTest extends TestCase
{
    use InteractsWithView;

    private function getConverter(array $data): ImageConverter
    {
        return new ImageConverter(
            [],
            $data
        );
    }

    /**
     * @test
     */
    public function it_converts_image_block(): void
    {
        $converter = $this->getConverter([
            'type' => 'image',
            'data' => [
                'file' => [
                    'url' => 'https://example.com/image.gif'
                ],
                'text' => 'Hello world'
            ]
        ]);

        $view = $converter->imageToHtml();

        static::assertViewHas($view, ['url' => 'https://example.com/image.gif']);
        static::assertViewHas($view, ['text' => 'Hello world']);
    }
}
