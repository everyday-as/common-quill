<?php

namespace Everyday\CommonQuill\Inline\Renderer;

use Everyday\CommonQuill\DeltaOp;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Element\Emphasis;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;

class EmphasisRenderer implements InlineRendererInterface
{
    /**
     * @param Emphasis                            $inline
     * @param \Everyday\CommonQuill\QuillRenderer $quillRenderer
     *
     * @return DeltaOp[]
     */
    public function render(AbstractInline $inline, ElementRendererInterface $quillRenderer)
    {
        if (!($inline instanceof Emphasis)) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . get_class($inline));
        }

        /** @var \Everyday\CommonQuill\DeltaOp[] $ops */
        $ops = $quillRenderer->renderInlines($inline->children());

        DeltaOp::applyAttributes($ops, ['italic' => true]);

        return $ops;
    }
}
