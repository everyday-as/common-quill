<?php

namespace Everyday\CommonQuill\Inline\Renderer;

use Everyday\CommonQuill\DeltaOp;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Element\Strong;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;

class StrongRenderer implements InlineRendererInterface
{
    /**
     * @param Strong                              $inline
     * @param \Everyday\CommonQuill\QuillRenderer $quillRenderer
     *
     * @return DeltaOp[]
     */
    public function render(AbstractInline $inline, ElementRendererInterface $quillRenderer)
    {
        if (!($inline instanceof Strong)) {
            throw new \InvalidArgumentException('Incompatible inline type: '.get_class($inline));
        }

        /** @var \Everyday\CommonQuill\DeltaOp[] $ops */
        $ops = $quillRenderer->renderInlines($inline->children());

        DeltaOp::applyAttributes($ops, ['bold' => true]);

        return $ops;
    }
}
