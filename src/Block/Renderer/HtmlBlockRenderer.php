<?php

namespace Everyday\CommonQuill\Block\Renderer;

use Everyday\HtmlToQuill\HtmlConverter;
use InvalidArgumentException;
use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\HtmlBlock;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;

class HtmlBlockRenderer implements BlockRendererInterface
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
     * @param AbstractBlock            $block
     * @param ElementRendererInterface $quillRenderer
     * @param bool                     $inTightList
     *
     * @return string
     */
    public function render(AbstractBlock $block, ElementRendererInterface $quillRenderer, $inTightList = false)
    {
        if (!($block instanceof HtmlBlock)) {
            throw new InvalidArgumentException('Incompatible block type: '.get_class($block));
        }

        $delta = $this->converter->convert($block->getStringContent());

        return serialize($delta->getOps());
    }
}
