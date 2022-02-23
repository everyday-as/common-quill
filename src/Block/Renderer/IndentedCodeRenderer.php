<?php

namespace Everyday\CommonQuill\Block\Renderer;

use Everyday\QuillDelta\DeltaOp;
use InvalidArgumentException;
use League\CommonMark\Extension\CommonMark\Node\Block\IndentedCode;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;

class IndentedCodeRenderer implements NodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        if (!($node instanceof IndentedCode)) {
            throw new InvalidArgumentException('Incompatible block type: ' . get_class($node));
        }

        return serialize(DeltaOp::text($node->getLiteral(), ['code-block' => true]));
    }
}
