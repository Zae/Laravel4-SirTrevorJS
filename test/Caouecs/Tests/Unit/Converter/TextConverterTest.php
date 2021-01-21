<?php

declare(strict_types=1);

namespace Caouecs\Tests\Unit\Converter;

use Caouecs\Sirtrevorjs\Converter\TextConverter;
use Caouecs\Tests\Traits\InteractsWithView;
use Caouecs\Tests\Unit\TestCase;

/**
 * Class TextConverterTest
 *
 * @package Caouecs\Tests\Unit
 */
class TextConverterTest extends TestCase
{
    use InteractsWithView;

    private function getConverter(array $data): TextConverter
    {
        return new TextConverter(
            new \ParsedownExtra(),
            [],
            $data
        );
    }

    /**
     * @test
     */
    public function it_converts_text_block(): void
    {
        $converter = $this->getConverter([
            'type' => 'text',
            'data' => [
                'text' => '#Hello world'
            ]
        ]);

        $view = $converter->textToHtml();

        static::assertViewHas($view, ['text' => '<h1>Hello world</h1>']);
    }

    /**
     * @test
     */
    public function it_converts_markdown_block(): void
    {
        $converter = $this->getConverter([
            'type' => 'text',
            'data' => [
                'text' => '#Hello world'
            ]
        ]);

        $view = $converter->markdownToHtml();

        static::assertViewHas($view, ['text' => '<h1>Hello world</h1>']);
    }

    /**
     * @test
     */
    public function it_converts_heading_block(): void
    {
        $converter = $this->getConverter([
            'type' => 'heading',
            'data' => [
                'text' => 'Hello world'
            ]
        ]);

        $view = $converter->headingToHtml();

        static::assertViewHas($view, ['text' => '<p>Hello world</p>']);
    }

    /**
     * @test
     */
    public function it_converts_blockquote_block(): void
    {
        $converter = $this->getConverter([
            'type' => 'blockquote',
            'data' => [
                'text' => 'Hello world'
            ]
        ]);

        $view = $converter->blockquoteToHtml();

        static::assertViewHas($view, [
            'cite' => null,
            'text' => '<p>Hello world</p>'
        ]);
    }

    /**
     * @test
     */
    public function it_converts_quote_block(): void
    {
        $converter = $this->getConverter([
            'type' => 'blockquote',
            'data' => [
                'text' => 'Hello world'
            ]
        ]);

        $view = $converter->quoteToHtml();

        static::assertViewHas($view, [
            'cite' => null,
            'text' => '<p>Hello world</p>'
        ]);
    }

    /**
     * @test
     */
    public function it_converts_list_block(): void
    {
        $converter = $this->getConverter([
            'type' => 'list',
            'data' => [
                'text' => "- Hello\n- world"
            ]
        ]);

        $view = $converter->listToHtml();

        static::assertViewHas($view, [
            'text' => "<ul>\n<li>Hello</li>\n<li>world</li>\n</ul>"
        ]);
    }
}
