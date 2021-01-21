<?php

declare(strict_types=1);

namespace Caouecs\Tests\Unit;

use Caouecs\Sirtrevorjs\SirTrevorJs;
use function count;

/**
 * Class SirTrevorJsTest
 *
 * @package Caouecs\Tests\Unit
 */
class SirTrevorJsTest extends TestCase
{
    private const TEXT_IMAGE_BLOCK = '{"data":[{"type":"text","data":{"text":"Some text block here"}},{"type":"text","data":{"text":"Another text here"}},{"type":"image","data":{"success":true,"file":{"url":"https://example.com/image.gif"}}}]}';

    /**
     * @test
     * @dataProvider blockArrayProvider
     *
     * @param string $text
     * @param string $blockType
     * @param int    $nbr
     * @param int    $expectedCount
     * @param array  $expectedContains
     */
    public function it_finds_blocks_in_array_format(string $text, string $blockType, int $nbr, int $expectedCount, array $expectedContains): void
    {
        $blocks = SirTrevorJs::find(
            $text,
            $blockType,
            'array',
            $nbr
        );

        static::assertCount($expectedCount, $blocks);
        if (count($blocks) > 0) {
            static::assertContains($expectedContains, $blocks);
        }
    }

    /**
     * @test
     * @dataProvider blockJsonProvider
     *
     * @param string $text
     * @param string $blockType
     * @param int    $nbr
     * @param string $expected
     */
    public function it_finds_blocks_in_json_format(string $text, string $blockType, int $nbr, string $expected): void
    {
        $blocks = SirTrevorJs::find(
            $text,
            $blockType,
            'json',
            $nbr
        );

        static::assertEquals($expected, $blocks);
    }

    /**
     * @test
     * @dataProvider blockFirstArrayProvider
     *
     * @param string $text
     * @param string $blockType
     * @param array  $expectedContains
     */
    public function it_finds_first_block_in_array_format(string $text, string $blockType, array $expectedContains): void
    {
        $blocks = SirTrevorJs::first(
            $text,
            $blockType,
            'array'
        );

        static::assertCount(1, $blocks);
        if (count($blocks) > 0) {
            static::assertContains($expectedContains, $blocks);
        }
    }

    /**
     * @test
     * @dataProvider blockFirstJsonProvider
     *
     * @param string $text
     * @param string $blockType
     * @param string $expected
     */
    public function it_finds_first_block_in_json_format(string $text, string $blockType, string $expected): void
    {
        $blocks = SirTrevorJs::first(
            $text,
            $blockType,
            'json'
        );

        static::assertEquals($expected, $blocks);
    }

    /**
     * @test
     * @dataProvider blockFirstJsonProvider
     *
     * @param string $text
     */
    public function it_returns_null_or_false_if_not_found(string $text): void
    {
        $array = SirTrevorJs::find(
            $text,
            'non-existent',
            'array'
        );
        $json = SirTrevorJs::find(
            $text,
            'non-existent',
            'json'
        );
        $array2 = SirTrevorJs::first(
            $text,
            'non-existent',
            'array'
        );
        $json2 = SirTrevorJs::first(
            $text,
            'non-existent',
            'json'
        );

        static::assertEquals(null, $array);
        static::assertEquals(null, $json);
        static::assertEquals(null, $array2);
        static::assertEquals(null, $json2);
    }

    public function blockArrayProvider(): array
    {
        return [
            [
                static::TEXT_IMAGE_BLOCK,
                'text',
                99,

                2,
                ['text' => 'Some text block here']
            ],
            [
                static::TEXT_IMAGE_BLOCK,
                'text',
                99,

                2,
                ['text' => 'Another text here']
            ],
            [
                static::TEXT_IMAGE_BLOCK,
                'image',
                99,

                1,
                [
                    'success' => true,
                    'file' => [
                        'url' => 'https://example.com/image.gif'
                    ]
                ]
            ],
            [
                static::TEXT_IMAGE_BLOCK,
                'text',
                1,

                1,
                ['text' => 'Some text block here']
            ],
        ];
    }

    public function blockJsonProvider(): array
    {
        return [
            [
                static::TEXT_IMAGE_BLOCK,
                'text',
                99,

                json_encode([['text' => 'Some text block here'], ['text' => 'Another text here']], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
            ],
            [
                static::TEXT_IMAGE_BLOCK,
                'image',
                99,

                json_encode([[
                    'success' => true,
                    'file' => [
                        'url' => 'https://example.com/image.gif'
                    ]
                ]], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
            ],
            [
                static::TEXT_IMAGE_BLOCK,
                'text',
                1,

                json_encode([['text' => 'Some text block here']], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
            ]
        ];
    }

    public function blockFirstArrayProvider(): array
    {
        return [
            [
                static::TEXT_IMAGE_BLOCK,
                'text',

                ['text' => 'Some text block here']
            ],
            [
                static::TEXT_IMAGE_BLOCK,
                'image',

                [
                    'success' => true,
                    'file' => [
                        'url' => 'https://example.com/image.gif'
                    ]
                ]
            ],
        ];
    }

    public function blockFirstJsonProvider(): array
    {
        return [
            [
                static::TEXT_IMAGE_BLOCK,
                'text',

                json_encode([['text' => 'Some text block here']], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
            ],
            [
                static::TEXT_IMAGE_BLOCK,
                'image',

                json_encode([[
                    'success' => true,
                    'file' => [
                        'url' => 'https://example.com/image.gif'
                    ]
                ]], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
            ],
            [
                static::TEXT_IMAGE_BLOCK,
                'text',

                json_encode([['text' => 'Some text block here']], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
            ],
        ];
    }
}
