<?php

namespace Everyday\CommonQuill\Block\Renderer;

use Everyday\CommonQuill\Concerns\InTightList;
use Everyday\QuillDelta\DeltaOp;
use InvalidArgumentException;
use League\CommonMark\Node\Block\Paragraph;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;

class ParagraphRenderer implements NodeRendererInterface
{
    use InTightList;

    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        if (!($node instanceof Paragraph)) {
            throw new InvalidArgumentException('Incompatible block type: '.get_class($node));
        }

        $ops = unserialize($childRenderer->renderNodes($node->children()), [
            'allowed_classes' => [DeltaOp::class],
        ]);

        if (!$this->inTightList($node)) {
            $ops[] = DeltaOp::text("\n");
        }

        return serialize($ops);
    }
}
