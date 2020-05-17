<?php

namespace Everyday\CommonQuill\Block\Renderer;

use Everyday\QuillDelta\DeltaOp;
use InvalidArgumentException;
use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\BlockQuote;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;

class BlockQuoteRenderer implements BlockRendererInterface
{
    /**
     * @param AbstractBlock            $block
     * @param ElementRendererInterface $quillRenderer
     * @param bool                     $inTightList
     *
     * @return string
     */
    public function render(AbstractBlock $block, ElementRendererInterface $quillRenderer, $inTightList = false)
    {
        if (!($block instanceof BlockQuote)) {
            throw new InvalidArgumentException('Incompatible block type: '.get_class($block));
        }

        $ops = [];

        // Filter ops as quill has limited support for block quotes
        /** @var DeltaOp $op */
        foreach (unserialize($quillRenderer->renderBlocks($block->children())) as $op) {
            if (!$op->isEmbed()) {
                // Strip new lines as quill only supports single-line block quotes
                $op->setInsert(str_replace("\n", ' ', trim($op->getInsert())));
            }

            // Remove certain block attributes from op
            $op->removeAttributes('blockquote', 'header', 'list', 'code-block');

            $ops[] = $op;
        }

        if (1 === count($ops)) {
            $ops[0]->setAttribute('blockquote', true);
        } else {
            $ops[] = DeltaOp::blockModifier('blockquote');
        }

        return serialize($ops);
    }
}
