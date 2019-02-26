<?php

namespace Everyday\CommonQuill\Inline\Renderer;

use Everyday\CommonQuill\DeltaOp;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Element\Newline;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;

class NewlineRenderer implements InlineRendererInterface
{
    /**
     * @param Newline                             $inline
     * @param \Everyday\CommonQuill\QuillRenderer $quillRenderer
     *
     * @return DeltaOp
     */
    public function render(AbstractInline $inline, ElementRendererInterface $quillRenderer)
    {
        if (!($inline instanceof Newline)) {
            throw new \InvalidArgumentException('Incompatible inline type: '.get_class($inline));
        }

        if (Newline::HARDBREAK === $inline->getType()) {
            return DeltaOp::text("\n");
        }

        return DeltaOp::text(' ');
    }
}
