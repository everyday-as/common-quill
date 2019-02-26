<?php

namespace Everyday\CommonQuill\Block\Renderer;

use Everyday\CommonQuill\DeltaOp;
use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\ListItem;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;

class ListItemRenderer implements BlockRendererInterface
{
    /**
     * @param ListItem                            $block
     * @param \Everyday\CommonQuill\QuillRenderer $quillRenderer
     * @param bool                                $inTightList
     *
     * @return DeltaOp[]
     */
    public function render(AbstractBlock $block, ElementRendererInterface $quillRenderer, $inTightList = false)
    {
        if (!($block instanceof ListItem)) {
            throw new \InvalidArgumentException('Incompatible block type: ' . get_class($block));
        }

        $ops = [];
        $contains_list = false;

        foreach ($quillRenderer->renderBlocks($block->children(), true) as $op) {
            if (!$op->isEmbed()) {
                // Strip new lines as quill only supports single-line list items
                $op->setInsert(str_replace("\n", ' ', $op->getInsert()));
            }

            // Remove certain block attributes from op
            $op->removeAttributes('blockquote', 'header', 'code-block');

            if ($op->hasAttribute('list')) {
                $contains_list = true;
            } else {
                $op->removeAttributes('indent');
            }

            $ops[] = $op;
        }

        // TODO: Currently the child list will render the delta for this `ListItem`, this is not ideal.
        if (!$contains_list) {
            $ops[] = DeltaOp::blockModifier('list', strtolower($block->getListData()->type));
        }

        return $ops;
    }
}