<?php

namespace Everyday\CommonQuill\Inline\Renderer;

use Everyday\QuillDelta\DeltaOp;
use InvalidArgumentException;
use League\CommonMark\Node\Inline\Newline;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;

class NewlineRenderer implements NodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        if (!($node instanceof Newline)) {
            throw new InvalidArgumentException('Incompatible inline type: ' . get_class($node));
        }

        if (Newline::HARDBREAK === $node->getType()) {
            return serialize(DeltaOp::text("\n"));
        }

        return serialize(DeltaOp::text(' '));
    }
}
