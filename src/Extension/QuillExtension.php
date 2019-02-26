<?php

namespace Everyday\CommonQuill\Extension;

use Everyday\CommonQuill\Block\Renderer as BlockRenderer;
use Everyday\CommonQuill\Inline\Renderer as InlineRenderer;
use League\CommonMark\Block\Element as BlockElement;
use League\CommonMark\Extension\Extension;
use League\CommonMark\Inline\Element as InlineElement;
use League\CommonMark\Inline\Processor\EmphasisProcessor;

class QuillExtension extends Extension
{
    /**
     * @return \League\CommonMark\Block\Parser\BlockParserInterface[]
     */
    public function getBlockParsers()
    {
        return [
            // This order is important
            new \League\CommonMark\Block\Parser\BlockQuoteParser(),
            new \League\CommonMark\Block\Parser\ATXHeadingParser(),
            new \League\CommonMark\Block\Parser\FencedCodeParser(),
            new \League\CommonMark\Block\Parser\HtmlBlockParser(),
            new \League\CommonMark\Block\Parser\SetExtHeadingParser(),
            new \League\CommonMark\Block\Parser\ThematicBreakParser(),
            new \League\CommonMark\Block\Parser\ListParser(),
            new \League\CommonMark\Block\Parser\IndentedCodeParser(),
            new \League\CommonMark\Block\Parser\LazyParagraphParser(),
        ];
    }

    /**
     * @return \League\CommonMark\Inline\Parser\InlineParserInterface[]
     */
    public function getInlineParsers()
    {
        return [
            new \League\CommonMark\Inline\Parser\NewlineParser(),
            new \League\CommonMark\Inline\Parser\BacktickParser(),
            new \League\CommonMark\Inline\Parser\EscapableParser(),
            new \League\CommonMark\Inline\Parser\EntityParser(),
            new \League\CommonMark\Inline\Parser\EmphasisParser(),
            new \League\CommonMark\Inline\Parser\AutolinkParser(),
            new \League\CommonMark\Inline\Parser\HtmlInlineParser(),
            new \League\CommonMark\Inline\Parser\CloseBracketParser(),
            new \League\CommonMark\Inline\Parser\OpenBracketParser(),
            new \League\CommonMark\Inline\Parser\BangParser(),
        ];
    }

    /**
     * @return \League\CommonMark\Inline\Processor\InlineProcessorInterface[]
     */
    public function getInlineProcessors()
    {
        return [
            new EmphasisProcessor(),
        ];
    }

    /**
     * @return \League\CommonMark\Block\Renderer\BlockRendererInterface[]
     */
    public function getBlockRenderers()
    {
        return [
            BlockElement\BlockQuote::class    => new BlockRenderer\BlockQuoteRenderer(),
            BlockElement\Document::class      => new BlockRenderer\DocumentRenderer(),
            BlockElement\FencedCode::class    => new BlockRenderer\FencedCodeRenderer(),
            BlockElement\Heading::class       => new BlockRenderer\HeadingRenderer(),
            BlockElement\HtmlBlock::class     => new BlockRenderer\HtmlBlockRenderer(),
            BlockElement\IndentedCode::class  => new BlockRenderer\IndentedCodeRenderer(),
            BlockElement\ListBlock::class     => new BlockRenderer\ListBlockRenderer(),
            BlockElement\ListItem::class      => new BlockRenderer\ListItemRenderer(),
            BlockElement\Paragraph::class     => new BlockRenderer\ParagraphRenderer(),
            BlockElement\ThematicBreak::class => new BlockRenderer\ThematicBreakRenderer(),
        ];
    }

    /**
     * @return \League\CommonMark\Inline\Renderer\InlineRendererInterface[]
     */
    public function getInlineRenderers()
    {
        return [
            InlineElement\Code::class       => new InlineRenderer\CodeRenderer(),
            InlineElement\Emphasis::class   => new InlineRenderer\EmphasisRenderer(),
            InlineElement\HtmlInline::class => new InlineRenderer\HtmlInlineRenderer(),
            InlineElement\Image::class      => new InlineRenderer\ImageRenderer(),
            InlineElement\Link::class       => new InlineRenderer\LinkRenderer(),
            InlineElement\Newline::class    => new InlineRenderer\NewlineRenderer(),
            InlineElement\Strong::class     => new InlineRenderer\StrongRenderer(),
            InlineElement\Text::class       => new InlineRenderer\TextRenderer(),
        ];
    }
}
