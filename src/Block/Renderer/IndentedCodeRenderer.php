<?php

namespace Everyday\CommonQuill\Block\Renderer;

use Everyday\QuillDelta\DeltaOp;
use InvalidArgumentException;
use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\IndentedCode;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;

class IndentedCodeRenderer implements BlockRendererInterface
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
        if (!($block instanceof IndentedCode)) {
            throw new InvalidArgumentException('Incompatible block type: ' . get_class($block));
        }

        return serialize(DeltaOp::text($block->getStringContent(), ['code-block' => true]));
    }
}
