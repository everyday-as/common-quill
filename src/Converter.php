<?php

namespace Everyday\CommonQuill;

use Everyday\QuillDelta\Delta;
use Everyday\QuillDelta\DeltaOp;
use League\CommonMark\Parser\MarkdownParserInterface;

class Converter implements ConverterInterface
{
    /**
     * Create a new commonmark converter instance.
     */
    public function __construct(protected MarkdownParserInterface $markdownParser, protected QuillRenderer $quillRenderer)
    {
    }

    /**
     * @param string $commonMark
     *
     * @return Delta
     */
    public function convertToQuill(string $commonMark): Delta
    {
        $document = $this->markdownParser->parse($commonMark);

        $delta = new Delta(unserialize($this->quillRenderer->renderDocument($document)->getContent(), [
            'allowed_classes' => [DeltaOp::class]
        ]));

        $delta->compact();

        return $delta;
    }

    /**
     * Converts CommonMark to Quill delta.
     *
     * @param string $commonMark
     *
     * @return Delta
     * @see Converter::convertToQuill
     *
     */
    public function __invoke(string $commonMark): Delta
    {
        return $this->convertToQuill($commonMark);
    }
}
