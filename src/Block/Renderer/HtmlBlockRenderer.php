<?php

namespace Everyday\CommonQuill\Block\Renderer;

use Everyday\HtmlToQuill\HtmlConverter;
use InvalidArgumentException;
use League\CommonMark\Extension\CommonMark\Node\Block\HtmlBlock;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;

class HtmlBlockRenderer implements NodeRendererInterface
{
    protected HtmlConverter $converter;

    public function __construct()
    {
        $this->converter = new HtmlConverter();
    }

    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        if (!($node instanceof HtmlBlock)) {
            throw new InvalidArgumentException('Incompatible block type: ' . get_class($node));
        }

        $delta = $this->converter->convert($node->getLiteral());

        return serialize($delta->getOps());
    }
}
