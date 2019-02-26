<?php

namespace Everyday\CommonQuill\Block\Renderer;

use Everyday\CommonQuill\DeltaOp;
use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\IndentedCode;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;

class IndentedCodeRenderer implements BlockRendererInterface
{
    /**
     * @param IndentedCode                        $block
     * @param \Everyday\CommonQuill\QuillRenderer $quillRenderer
     * @param bool                                $inTightList
     *
     * @return DeltaOp
     */
    public function render(AbstractBlock $block, ElementRendererInterface $quillRenderer, $inTightList = false)
    {
        if (!($block instanceof IndentedCode)) {
            throw new \InvalidArgumentException('Incompatible block type: ' . get_class($block));
        }

        return DeltaOp::text($block->getStringContent(), ['code-block' => true]);
    }
}