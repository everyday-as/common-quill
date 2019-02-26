<?php

namespace Everyday\CommonQuill\Block\Renderer;

use Everyday\CommonQuill\Delta;
use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\Document;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Util\Configuration;
use League\CommonMark\Util\ConfigurationAwareInterface;

class DocumentRenderer implements BlockRendererInterface, ConfigurationAwareInterface
{
    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @param AbstractBlock                       $block
     * @param \Everyday\CommonQuill\QuillRenderer $quillRenderer
     * @param bool                                $inTightList
     *
     * @return Delta
     */
    public function render(AbstractBlock $block, ElementRendererInterface $quillRenderer, $inTightList = false)
    {
        if (!($block instanceof Document)) {
            throw new \InvalidArgumentException('Incompatible block type: '.get_class($block));
        }

        /** @var Delta $delta */
        $delta = new Delta($quillRenderer->renderBlocks($block->children()));

        if ($this->config->getConfig('compact_delta')) {
            $delta->compact();
        }

        return $delta;
    }

    /**
     * @param Configuration $configuration
     */
    public function setConfiguration(Configuration $configuration)
    {
        $this->config = $configuration;
    }
}
