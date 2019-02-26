<?php

namespace Everyday\CommonQuill\Inline\Renderer;

use Everyday\CommonQuill\DeltaOp;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Element\Text;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;

class TextRenderer implements InlineRendererInterface
{
    /**
     * @param Text                                $inline
     * @param \Everyday\CommonQuill\QuillRenderer $quillRenderer
     *
     * @return DeltaOp
     */
    public function render(AbstractInline $inline, ElementRendererInterface $quillRenderer)
    {
        if (!($inline instanceof Text)) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . get_class($inline));
        }

        return DeltaOp::text($inline->getContent());
    }
}
