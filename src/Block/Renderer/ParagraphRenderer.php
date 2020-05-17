<?php

namespace Everyday\CommonQuill\Block\Renderer;

use Everyday\QuillDelta\DeltaOp;
use InvalidArgumentException;
use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\Paragraph;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;

class ParagraphRenderer implements BlockRendererInterface
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
        if (!($block instanceof Paragraph)) {
            throw new InvalidArgumentException('Incompatible block type: ' . get_class($block));
        }

        $ops = unserialize($quillRenderer->renderInlines($block->children()));

        if (!$inTightList) {
            $ops[] = DeltaOp::text("\n");
        }

        return serialize($ops);
    }
}
