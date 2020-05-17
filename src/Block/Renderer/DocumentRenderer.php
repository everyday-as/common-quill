<?php

namespace Everyday\CommonQuill\Block\Renderer;

use Everyday\QuillDelta\Delta;
use InvalidArgumentException;
use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\Document;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Util\Configuration;
use League\CommonMark\Util\ConfigurationAwareInterface;
use League\CommonMark\Util\ConfigurationInterface;

class DocumentRenderer implements BlockRendererInterface, ConfigurationAwareInterface
{
    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @param AbstractBlock            $block
     * @param ElementRendererInterface $quillRenderer
     * @param bool                     $inTightList
     *
     * @return string
     */
    public function render(AbstractBlock $block, ElementRendererInterface $quillRenderer, $inTightList = false)
    {
        if (!($block instanceof Document)) {
            throw new InvalidArgumentException('Incompatible block type: '.get_class($block));
        }

        $ops = unserialize($quillRenderer->renderBlocks($block->children()));

        if (!empty($ops) && !$ops[0]->isEmbed() && !$ops[0]->isBlockModifier()) {
            $ops[0]->setInsert(ltrim($ops[0]->getInsert()));
        }

        $delta = new Delta($ops);

        if ($this->config->get('compact_delta')) {
            $delta->compact();
        }

        return serialize($delta);
    }

    /**
     * @param ConfigurationInterface $configuration
     */
    public function setConfiguration(ConfigurationInterface $configuration)
    {
        $this->config = $configuration;
    }
}
