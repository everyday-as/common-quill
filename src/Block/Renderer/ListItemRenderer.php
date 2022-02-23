<?php

namespace Everyday\CommonQuill\Block\Renderer;

use Everyday\QuillDelta\DeltaOp;
use InvalidArgumentException;
use League\CommonMark\Extension\CommonMark\Node\Block\ListItem;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;

class ListItemRenderer implements NodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        if (!($node instanceof ListItem)) {
            throw new InvalidArgumentException('Incompatible block type: ' . get_class($node));
        }

        $ops = [];
        $containsList = false;

        $childOps = unserialize($childRenderer->renderNodes($node->children()), [
            'allowed_classes' => [DeltaOp::class]
        ]);

        foreach ($childOps as $op) {
            if (!$op->isBlockModifier() && !$op->isEmbed()) {
                // Strip new lines as quill only supports single-line list items
                $op->setInsert(str_replace("\n", ' ', $op->getInsert()));
            }

            // Remove certain block attributes from op
            $op->removeAttributes('blockquote', 'header', 'code-block');

            if ($op->hasAttribute('list')) {
                $containsList = true;
            } else {
                $op->removeAttributes('indent');
            }

            if ("\n" === $op->getInsert() && empty($op->getAttributes())) {
                continue;
            }

            $ops[] = $op;
        }

        // TODO: Currently the child list will render the delta for this `ListItem`, this is not ideal.
        if (!$containsList) {
            $ops[] = DeltaOp::blockModifier('list', strtolower($node->getListData()->type));
        }

        return serialize($ops);
    }
}
