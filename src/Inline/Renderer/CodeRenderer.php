<?php

namespace Everyday\CommonQuill\Inline\Renderer;

use Everyday\QuillDelta\DeltaOp;
use InvalidArgumentException;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;

class CodeRenderer implements NodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        if (!($node instanceof Code)) {
            throw new InvalidArgumentException('Incompatible inline type: ' . get_class($node));
        }

        return serialize(DeltaOp::text($node->getLiteral(), ['code' => true]));
    }
}
