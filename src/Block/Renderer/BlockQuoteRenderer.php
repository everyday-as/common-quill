<?php

namespace Everyday\CommonQuill\Block\Renderer;

use Everyday\CommonQuill\DeltaOp;
use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\BlockQuote;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;

class BlockQuoteRenderer implements BlockRendererInterface
{
    /**
     * @param BlockQuote                          $block
     * @param \Everyday\CommonQuill\QuillRenderer $quillRenderer
     * @param bool                                $inTightList
     *
     * @return DeltaOp[]
     */
    public function render(AbstractBlock $block, ElementRendererInterface $quillRenderer, $inTightList = false)
    {
        if (!($block instanceof BlockQuote)) {
            throw new \InvalidArgumentException('Incompatible block type: ' . get_class($block));
        }

        $ops = [];

        // Filter ops as quill has limited support for block quotes
        /** @var DeltaOp $op */
        foreach ($quillRenderer->renderBlocks($block->children()) as $op) {
            if (!$op->isEmbed()) {
                // Strip new lines as quill only supports single-line block quotes
                $op->setInsert(str_replace("\n", ' ', $op->getInsert()));
            }

            // Remove certain block attributes from op
            $op->removeAttributes('blockquote', 'header', 'list', 'code-block');

            $ops[] = $op;
        }

        if (1 === count($ops)) {
            $ops[0]->setAttribute('blockquote', true);
        } else {
            $ops[] = DeltaOp::text("\n", ['blockquote' => true]);
        }

        return $ops;
    }
}