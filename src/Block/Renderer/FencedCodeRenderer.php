<?php

namespace Everyday\CommonQuill\Block\Renderer;

use Everyday\QuillDelta\DeltaOp;
use InvalidArgumentException;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;

class FencedCodeRenderer implements NodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        if (!($node instanceof FencedCode)) {
            throw new InvalidArgumentException('Incompatible block type: '.get_class($node));
        }

        $literal = $node->getLiteral();
        if (!str_ends_with($literal, "\n")) {
            $literal .= "\n";
        }

        return serialize(DeltaOp::text($literal, ['code-block' => true]));
    }
}
