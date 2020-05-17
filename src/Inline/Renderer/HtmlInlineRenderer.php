<?php

namespace Everyday\CommonQuill\Inline\Renderer;

use Everyday\HtmlToQuill\HtmlConverter;
use Everyday\QuillDelta\DeltaOp;
use Exception;
use InvalidArgumentException;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Element\HtmlInline;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;

class HtmlInlineRenderer implements InlineRendererInterface
{
    /**
     * @var HtmlConverter
     */
    protected $converter;

    public function __construct()
    {
        $this->converter = new HtmlConverter();
    }

    /**
     * @param AbstractInline $inline
     * @param ElementRendererInterface $quillRenderer
     *
     * @return string
     * @throws Exception
     */
    public function render(AbstractInline $inline, ElementRendererInterface $quillRenderer)
    {
        if (!($inline instanceof HtmlInline)) {
            throw new InvalidArgumentException('Incompatible inline type: ' . get_class($inline));
        }

        // TODO: Render the HTML inline to a Quill delta
        return serialize(DeltaOp::text($inline->getContent()));
    }
}
