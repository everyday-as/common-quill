<?php

namespace Everyday\CommonQuill\Block\Renderer;

use Everyday\CommonQuill\Concerns\InTightList;
use Everyday\CommonQuill\QuillRenderer;
use Everyday\QuillDelta\DeltaOp;
use InvalidArgumentException;
use League\CommonMark\Extension\CommonMark\Node\Block\ListBlock;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;

class ListBlockRenderer implements NodeRendererInterface
{
    use InTightList;

    /**
     * @param QuillRenderer $childRenderer
     */
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        if (!($node instanceof ListBlock)) {
            throw new InvalidArgumentException('Incompatible block type: ' . get_class($node));
        }

        // All lists are tight
        $ops = unserialize($childRenderer->renderNodes($node->children()), [
            'allowed_classes' => [DeltaOp::class]
        ]);

        foreach ($ops as $op) {
            if ($op->hasAttribute('list')) {
                $op->setAttribute('indent', ($op->getAttribute('indent') ?? -1) + 1);
            }
        }

        if ($this->inTightList($node)) {
            $parent = $node->parent();

            while (!($parent instanceof ListBlock)) {
                $parent = $parent->parent();
            }

            $ops = array_merge([
                DeltaOp::blockModifier('list', strtolower($parent->getListData()->type)),
            ], $ops);
        }

        return serialize($ops);
    }
}
