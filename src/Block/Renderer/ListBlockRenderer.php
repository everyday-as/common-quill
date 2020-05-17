<?php

namespace Everyday\CommonQuill\Block\Renderer;

use Everyday\QuillDelta\DeltaOp;
use InvalidArgumentException;
use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\ListBlock;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;

class ListBlockRenderer implements BlockRendererInterface
{
    /**
     * @param AbstractBlock $block
     * @param ElementRendererInterface $quillRenderer
     * @param bool $inTightList
     *
     * @return string
     */
    public function render(AbstractBlock $block, ElementRendererInterface $quillRenderer, $inTightList = false)
    {
        if (!($block instanceof ListBlock)) {
            throw new InvalidArgumentException('Incompatible block type: '.get_class($block));
        }

        // All lists are tight
        $ops = unserialize($quillRenderer->renderBlocks($block->children(), true));

        foreach ($ops as $op) {
            if ($op->hasAttribute('list')) {
                $op->setAttribute('indent', ($op->getAttribute('indent') ?? -1) + 1);
            }
        }

        if ($inTightList) {
            $parent = $block->parent();

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
