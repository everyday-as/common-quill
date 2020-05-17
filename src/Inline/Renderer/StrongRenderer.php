<?php

namespace Everyday\CommonQuill\Inline\Renderer;

use Everyday\QuillDelta\DeltaOp;
use InvalidArgumentException;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Element\Strong;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;

class StrongRenderer implements InlineRendererInterface
{
    /**
     * @param AbstractInline $inline
     * @param ElementRendererInterface $quillRenderer
     *
     * @return string
     */
    public function render(AbstractInline $inline, ElementRendererInterface $quillRenderer)
    {
        if (!($inline instanceof Strong)) {
            throw new InvalidArgumentException('Incompatible inline type: ' . get_class($inline));
        }

        $ops = unserialize($quillRenderer->renderInlines($inline->children()));

        DeltaOp::applyAttributes($ops, ['bold' => true]);

        return serialize($ops);
    }
}
