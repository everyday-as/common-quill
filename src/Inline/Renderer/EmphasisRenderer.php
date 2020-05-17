<?php

namespace Everyday\CommonQuill\Inline\Renderer;

use Everyday\QuillDelta\DeltaOp;
use InvalidArgumentException;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Element\Emphasis;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;

class EmphasisRenderer implements InlineRendererInterface
{
    /**
     * @param AbstractInline           $inline
     * @param ElementRendererInterface $quillRenderer
     *
     * @return string
     */
    public function render(AbstractInline $inline, ElementRendererInterface $quillRenderer)
    {
        if (!($inline instanceof Emphasis)) {
            throw new InvalidArgumentException('Incompatible inline type: '.get_class($inline));
        }

        /** @var DeltaOp[] $ops */
        $ops = unserialize($quillRenderer->renderInlines($inline->children()));

        DeltaOp::applyAttributes($ops, ['italic' => true]);

        return serialize($ops);
    }
}
