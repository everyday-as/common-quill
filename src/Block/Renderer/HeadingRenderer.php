<?php

namespace Everyday\CommonQuill\Block\Renderer;

use Everyday\CommonQuill\DeltaOp;
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

        $ops = $quillRenderer->renderInlines($block->children());

        $ops[] = DeltaOp::text("\n", ['header' => $block->getLevel()]);

        return $ops;
    }
}
