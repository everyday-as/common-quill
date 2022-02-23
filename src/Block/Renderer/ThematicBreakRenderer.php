<?php

namespace Everyday\CommonQuill\Block\Renderer;

use Everyday\QuillDelta\DeltaOp;
use InvalidArgumentException;
use League\CommonMark\Extension\CommonMark\Node\Block\ThematicBreak;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;

class ThematicBreakRenderer implements NodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        if (!($node instanceof ThematicBreak)) {
            throw new InvalidArgumentException('Incompatible block type: ' . get_class($node));
        }

        return serialize(DeltaOp::text("\n"));
    }
}
