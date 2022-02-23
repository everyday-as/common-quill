<?php

namespace Everyday\CommonQuill\Block\Renderer;

use Everyday\QuillDelta\DeltaOp;
use InvalidArgumentException;
use League\CommonMark\Extension\CommonMark\Node\Block\BlockQuote;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;

class BlockQuoteRenderer implements NodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        if (!($node instanceof BlockQuote)) {
            throw new InvalidArgumentException('Incompatible block type: '.get_class($node));
        }

        $ops = unserialize($childRenderer->renderNodes($node->children()), [
            'allowed_classes' => [DeltaOp::class],
        ]);

        $filteredOps = [];

        // Filter ops as quill has limited support for block quotes
        /** @var DeltaOp $op */
        foreach ($ops as $op) {
            if (!$op->isEmbed()) {
                // Strip new lines as quill only supports single-line block quotes
                $op->setInsert(str_replace("\n", ' ', trim($op->getInsert())));
            }

            // Remove certain block attributes from op
            $op->removeAttributes('blockquote', 'header', 'list', 'code-block');

            $filteredOps[] = $op;
        }

        if (1 === count($filteredOps)) {
            $filteredOps[0]->setAttribute('blockquote', true);
        } else {
            $filteredOps[] = DeltaOp::blockModifier('blockquote');
        }

        return serialize($filteredOps);
    }
}
