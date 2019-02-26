<?php

namespace Everyday\CommonQuill\Block\Renderer;

use Everyday\QuillDelta\DeltaOp;
use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\Heading;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;

class HeadingRenderer implements BlockRendererInterface
{
    /**
     * @param Heading                             $block
     * @param \Everyday\CommonQuill\QuillRenderer $quillRenderer
     * @param bool                                $inTightList
     *
     * @return DeltaOp[]
     */
    public function render(AbstractBlock $block, ElementRendererInterface $quillRenderer, $inTightList = false)
    {
        if (!($block instanceof Heading)) {
            throw new \InvalidArgumentException('Incompatible block type: '.get_class($block));
        }

        return array_merge(
            [DeltaOp::text("\n")],
            $quillRenderer->renderInlines($block->children()),
            [DeltaOp::blockModifier('header', $block->getLevel())]
        );
    }
}
