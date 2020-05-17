<?php

namespace Everyday\CommonQuill\Inline\Renderer;

use Everyday\QuillDelta\DeltaOp;
use InvalidArgumentException;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Element\Newline;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;

class NewlineRenderer implements InlineRendererInterface
{
    /**
     * @param AbstractInline $inline
     * @param ElementRendererInterface $quillRenderer
     *
     * @return string
     */
    public function render(AbstractInline $inline, ElementRendererInterface $quillRenderer)
    {
        if (!($inline instanceof Newline)) {
            throw new InvalidArgumentException('Incompatible inline type: '.get_class($inline));
        }

        if (Newline::HARDBREAK === $inline->getType()) {
            return serialize(DeltaOp::text("\n"));
        }

        return serialize(DeltaOp::text(' '));
    }
}
