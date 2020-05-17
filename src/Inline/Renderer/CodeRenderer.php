<?php

namespace Everyday\CommonQuill\Inline\Renderer;

use Everyday\QuillDelta\DeltaOp;
use InvalidArgumentException;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Element\Code;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;

class CodeRenderer implements InlineRendererInterface
{
    /**
     * @param AbstractInline           $inline
     * @param ElementRendererInterface $quillRenderer
     *
     * @return string
     */
    public function render(AbstractInline $inline, ElementRendererInterface $quillRenderer)
    {
        if (!($inline instanceof Code)) {
            throw new InvalidArgumentException('Incompatible inline type: '.get_class($inline));
        }

        return serialize(DeltaOp::text($inline->getContent(), ['code' => true]));
    }
}
