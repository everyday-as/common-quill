<?php

namespace Everyday\CommonQuill;

use Everyday\QuillDelta\Delta;
use League\CommonMark\DocParser;
use League\CommonMark\ElementRendererInterface;

class Converter implements ConverterInterface
{
    /**
     * The document parser instance.
     *
     * @var DocParser
     */
    protected $docParser;

    /**
     * The html renderer instance.
     *
     * @var ElementRendererInterface
     */
    protected $quillRenderer;

    /**
     * Create a new commonmark converter instance.
     *
     * @param DocParser                $docParser
     * @param ElementRendererInterface $quillRenderer
     */
    public function __construct(DocParser $docParser, ElementRendererInterface $quillRenderer)
    {
        $this->docParser = $docParser;
        $this->quillRenderer = $quillRenderer;
    }

    /**
     * @param string $commonMark
     *
     * @return Delta
     */
    public function convertToQuill($commonMark)
    {
        $documentAST = $this->docParser->parse($commonMark);

        return unserialize($this->quillRenderer->renderBlock($documentAST));
    }

    /**
     * Converts CommonMark to Quill delta.
     *
     * @see Converter::convertToQuill
     *
     * @param string $commonMark
     *
     * @return string
     */
    public function __invoke($commonMark)
    {
        return $this->convertToQuill($commonMark);
    }
}
