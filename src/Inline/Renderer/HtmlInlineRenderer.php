<?php

namespace Everyday\CommonQuill\Inline\Renderer;

use Everyday\HtmlToQuill\HtmlConverter;
use Everyday\QuillDelta\DeltaOp;
use InvalidArgumentException;
use League\CommonMark\Extension\CommonMark\Node\Inline\HtmlInline;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;

class HtmlInlineRenderer implements NodeRendererInterface
{
    protected HtmlConverter $converter;

    public function __construct()
    {
        $this->converter = new HtmlConverter();
    }

    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        if (!($node instanceof HtmlInline)) {
            throw new InvalidArgumentException('Incompatible inline type: '.get_class($node));
        }

        // TODO: Render the HTML inline to a Quill delta
        return serialize(DeltaOp::text($node->getLiteral()));
    }
}
