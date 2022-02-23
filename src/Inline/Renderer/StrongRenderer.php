<?php

namespace Everyday\CommonQuill\Inline\Renderer;

use Everyday\QuillDelta\DeltaOp;
use InvalidArgumentException;
use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;

class StrongRenderer implements NodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        if (!($node instanceof Strong)) {
            throw new InvalidArgumentException('Incompatible inline type: ' . get_class($node));
        }

        $ops = unserialize($childRenderer->renderNodes($node->children()), [
            'allowed_classes' => [DeltaOp::class]
        ]);

        DeltaOp::applyAttributes($ops, ['bold' => true]);

        return serialize($ops);
    }
}
