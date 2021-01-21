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
use ParsedownExtra;

/**
 * Text for Sir Trevor Js by Markdown.
 */
class TextConverter extends BaseConverter implements ConverterInterface
{
    /**
     * Markdown.
     *
     * @var ParsedownExtra
     */
    protected $markdown;

    /**
     * List of types for text.
     *
     * @var array
     */
    protected $types = [
        'text',
        'markdown',
        'quote',
        'blockquote',
        'heading',
        'list',
    ];

    /**
     * Construct.
     *
     * @param ParsedownExtra $markdown
     * @param array          $config Config of Sir Trevor Js
     * @param array          $data   Array of data
     *
     */
    public function __construct(ParsedownExtra $markdown, array $config, array $data)
    {
        $this->markdown = $markdown;
        $this->markdown->setBreaksEnabled(true);

        parent::__construct($config, $data);
    }

    /**
     * Convert text from markdown or html.
     *
     * @return View
     */
    public function textToHtml(): View
    {
        $text = $this->data['text'] ?? '';

        if (!isset($this->data['isHtml']) || !($this->data['isHtml'])) {
            /** This replacement happens to prevent a spacing issues between headers (**header**) in a markdown text */
            $text = str_replace("**\n", '** <br>', $text);
            $text = $this->markdown->text($text);
        }

        return $this->view('text.text', [
            'text' => $text,
        ]);
    }

    /**
     * Convert text from markdown.
     *
     * @return View
     */
    public function markdownToHtml(): View
    {
        return $this->textToHtml();
    }

    /**
     * Convert heading.
     *
     * @return View
     */
    public function headingToHtml(): View
    {
        $text = $this->data['text'] ?? '';

        return $this->view('text.heading', [
            'text' => $this->markdown->text($text),
        ]);
    }

    /**
     * Converts block quotes to html.
     *
     * @return View
     */
    public function blockquoteToHtml(): View
    {
        $cite = $this->data['cite'] ?? null;
        $text = $this->data['text'] ?? '';

        // remove the indent that's added by Sir Trevor
        return $this->view('text.blockquote', [
            'cite' => $cite,
            'text' => $this->markdown->text(ltrim($text, '>')),
        ]);
    }

    /**
     * Converts quote to html.
     *
     * @return View
     */
    public function quoteToHtml(): View
    {
        return $this->blockquoteToHtml();
    }

	/**
     * Converts list to html.
     *
     * @return View
     */
    public function listToHtml(): View
    {
        return $this->textToHtml();
    }
}
