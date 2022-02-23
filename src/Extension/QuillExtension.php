<?php

namespace Everyday\CommonQuill\Extension;

use Everyday\CommonQuill\Block\Renderer as BlockRenderer;
use Everyday\CommonQuill\Inline\Renderer as InlineRenderer;
use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\CommonMark\Node\Block as BlockNodeExtension;
use League\CommonMark\Extension\CommonMark\Node\Inline as InlineNodeExtension;
use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\Node\Block as BlockNode;
use League\CommonMark\Node\Inline as InlineNode;

class QuillExtension implements ExtensionInterface
{
    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment
            ->addRenderer(BlockNodeExtension\BlockQuote::class, new BlockRenderer\BlockQuoteRenderer(), 10)
            ->addRenderer(BlockNode\Document::class, new BlockRenderer\DocumentRenderer(), 10)
            ->addRenderer(BlockNodeExtension\FencedCode::class, new BlockRenderer\FencedCodeRenderer(), 10)
            ->addRenderer(BlockNodeExtension\Heading::class, new BlockRenderer\HeadingRenderer(), 10)
            ->addRenderer(BlockNodeExtension\HtmlBlock::class, new BlockRenderer\HtmlBlockRenderer(), 10)
            ->addRenderer(BlockNodeExtension\IndentedCode::class, new BlockRenderer\IndentedCodeRenderer(), 10)
            ->addRenderer(BlockNodeExtension\ListBlock::class, new BlockRenderer\ListBlockRenderer(), 10)
            ->addRenderer(BlockNodeExtension\ListItem::class, new BlockRenderer\ListItemRenderer(), 10)
            ->addRenderer(BlockNode\Paragraph::class, new BlockRenderer\ParagraphRenderer(), 10)
            ->addRenderer(BlockNodeExtension\ThematicBreak::class, new BlockRenderer\ThematicBreakRenderer(), 10)
            ->addRenderer(InlineNodeExtension\Code::class, new InlineRenderer\CodeRenderer(), 10)
            ->addRenderer(InlineNodeExtension\Emphasis::class, new InlineRenderer\EmphasisRenderer(), 10)
            ->addRenderer(InlineNodeExtension\HtmlInline::class, new InlineRenderer\HtmlInlineRenderer(), 10)
            ->addRenderer(InlineNodeExtension\Image::class, new InlineRenderer\ImageRenderer(), 10)
            ->addRenderer(InlineNodeExtension\Link::class, new InlineRenderer\LinkRenderer(), 10)
            ->addRenderer(InlineNode\Newline::class, new InlineRenderer\NewlineRenderer(), 10)
            ->addRenderer(InlineNodeExtension\Strong::class, new InlineRenderer\StrongRenderer(), 10)
            ->addRenderer(InlineNode\Text::class, new InlineRenderer\TextRenderer(), 10);
    }
}
