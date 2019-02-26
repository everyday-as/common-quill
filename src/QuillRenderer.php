<?php

namespace Everyday\CommonQuill;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Environment;
use League\CommonMark\Inline\Element\AbstractInline;

class QuillRenderer implements ElementRendererInterface
{
    /**
     * @var Environment
     */
    protected $environment;

    /**
     * @param Environment $environment
     */
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * @param string $option
     * @param mixed  $default
     *
     * @return mixed
     */
    public function getOption($option, $default = null)
    {
        return $this->environment->getConfig('renderer/'.$option, $default);
    }

    /**
     * @param AbstractInline $inline
     *
     * @throws \RuntimeException
     *
     * @return DeltaOp[]
     */
    protected function renderInline(AbstractInline $inline)
    {
        $renderer = $this->environment->getInlineRendererForClass(get_class($inline));

        if (!$renderer) {
            throw new \RuntimeException('Unable to find corresponding renderer for inline type '.get_class($inline));
        }

        return $renderer->render($inline, $this);
    }

    /**
     * @param AbstractInline[] $inlines
     *
     * @return DeltaOp[]
     */
    public function renderInlines($inlines)
    {
        $result = [];

        foreach ($inlines as $inline) {
            $result[] = $this->renderInline($inline);
        }

        return array_flatten($result);
    }

    /**
     * @param AbstractBlock $block
     * @param bool          $inTightList
     *
     * @throws \RuntimeException
     *
     * @return DeltaOp[]
     */
    public function renderBlock(AbstractBlock $block, $inTightList = false)
    {
        $renderer = $this->environment->getBlockRendererForClass(get_class($block));

        if (!$renderer) {
            throw new \RuntimeException('Unable to find corresponding renderer for block type '.get_class($block));
        }

        return $renderer->render($block, $this, $inTightList);
    }

    /**
     * @param AbstractBlock[] $blocks
     * @param bool            $inTightList
     *
     * @return DeltaOp[]
     */
    public function renderBlocks($blocks, $inTightList = false)
    {
        $result = [];
        foreach ($blocks as $block) {
            $result[] = $this->renderBlock($block, $inTightList);
        }

        return array_flatten($result);
    }
}
