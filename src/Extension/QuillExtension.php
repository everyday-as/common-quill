<?php

namespace Everyday\CommonQuill\Extension;

use Everyday\CommonQuill\Block\Renderer as BlockRenderer;
use Everyday\CommonQuill\Inline\Renderer as InlineRenderer;
use League\CommonMark\Block\Element as BlockElement;
use League\CommonMark\ConfigurableEnvironmentInterface;
use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\Inline\Element as InlineElement;

class QuillExtension implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment
            ->addBlockRenderer(BlockElement\BlockQuote::class, new BlockRenderer\BlockQuoteRenderer, 10)
            ->addBlockRenderer(BlockElement\Document::class, new BlockRenderer\DocumentRenderer, 10)
            ->addBlockRenderer(BlockElement\FencedCode::class, new BlockRenderer\FencedCodeRenderer, 10)
            ->addBlockRenderer(BlockElement\Heading::class, new BlockRenderer\HeadingRenderer, 10)
            ->addBlockRenderer(BlockElement\HtmlBlock::class, new BlockRenderer\HtmlBlockRenderer, 10)
            ->addBlockRenderer(BlockElement\IndentedCode::class, new BlockRenderer\IndentedCodeRenderer, 10)
            ->addBlockRenderer(BlockElement\ListBlock::class, new BlockRenderer\ListBlockRenderer, 10)
            ->addBlockRenderer(BlockElement\ListItem::class, new BlockRenderer\ListItemRenderer, 10)
            ->addBlockRenderer(BlockElement\Paragraph::class, new BlockRenderer\ParagraphRenderer, 10)
            ->addBlockRenderer(BlockElement\ThematicBreak::class, new BlockRenderer\ThematicBreakRenderer, 10)

            ->addInlineRenderer(InlineElement\Code::class, new InlineRenderer\CodeRenderer, 10)
            ->addInlineRenderer(InlineElement\Emphasis::class, new InlineRenderer\EmphasisRenderer, 10)
            ->addInlineRenderer(InlineElement\HtmlInline::class, new InlineRenderer\HtmlInlineRenderer, 10)
            ->addInlineRenderer(InlineElement\Image::class, new InlineRenderer\ImageRenderer, 10)
            ->addInlineRenderer(InlineElement\Link::class, new InlineRenderer\LinkRenderer, 10)
            ->addInlineRenderer(InlineElement\Newline::class, new InlineRenderer\NewlineRenderer, 10)
            ->addInlineRenderer(InlineElement\Strong::class, new InlineRenderer\StrongRenderer, 10)
            ->addInlineRenderer(InlineElement\Text::class, new InlineRenderer\TextRenderer, 10);
    }
}
