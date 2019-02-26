<?php

namespace Everyday\CommonQuill\Inline\Renderer;

use Everyday\QuillDelta\DeltaOp;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Element\Code;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;

class CodeRenderer implements InlineRendererInterface
{
    /**
     * @param Code                                $inline
     * @param \Everyday\CommonQuill\QuillRenderer $quillRenderer
     *
     * @return DeltaOp
     */
    public function render(AbstractInline $inline, ElementRendererInterface $quillRenderer)
    {
        if (!($inline instanceof Code)) {
            throw new \InvalidArgumentException('Incompatible inline type: '.get_class($inline));
        }

        return DeltaOp::text($inline->getContent(), ['code' => true]);
    }
}
