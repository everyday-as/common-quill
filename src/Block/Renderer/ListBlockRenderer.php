<?php

namespace Everyday\CommonQuill\Block\Renderer;

use Everyday\CommonQuill\DeltaOp;
use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\ListBlock;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;

class ListBlockRenderer implements BlockRendererInterface
{
    /**
     * @param ListBlock                           $block
     * @param \Everyday\CommonQuill\QuillRenderer $quillRenderer
     * @param bool                                $inTightList
     *
     * @return DeltaOp[]
     */
    public function render(AbstractBlock $block, ElementRendererInterface $quillRenderer, $inTightList = false)
    {
        if (!($block instanceof ListBlock)) {
            throw new \InvalidArgumentException('Incompatible block type: ' . get_class($block));
        }

        // All lists are tight
        $ops = $quillRenderer->renderBlocks($block->children(), true);

        foreach ($ops as $op) {
            if ($op->hasAttribute('list')) {
                $op->setAttribute('indent', ($op->getAttribute('indent') ?? -1) + 1);
            }
        }

        if ($inTightList) {
            $parent = $block->parent();

            while (!($parent instanceof ListBlock)) $parent = $parent->parent();

            $ops = array_merge([
                DeltaOp::blockModifier('list', strtolower($parent->getListData()->type))
            ], $ops);
        }

        return $ops;
    }
}
