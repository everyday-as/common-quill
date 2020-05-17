<?php

namespace Everyday\CommonQuill;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\EnvironmentInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;
use RuntimeException;
use function get_class;

class QuillRenderer implements ElementRendererInterface
{
    /**
     * @var EnvironmentInterface
     */
    protected $environment;

    /**
     * @param EnvironmentInterface $environment
     */
    public function __construct(EnvironmentInterface $environment)
    {
        $this->environment = $environment;
    }

    /**
     * @param string $option
     * @param mixed $default
     *
     * @return mixed
     */
    public function getOption($option, $default = null)
    {
        return $this->environment->getConfig('renderer/' . $option, $default);
    }

    /**
     * @param AbstractInline $inline
     *
     * @return string
     * @throws RuntimeException
     *
     */
    public function renderInline(AbstractInline $inline): string
    {
        $renderers = $this->environment->getInlineRenderersForClass(get_class($inline));

        /** @var InlineRendererInterface $renderer */
        foreach ($renderers as $renderer) {
            if (($result = $renderer->render($inline, $this)) !== null) {
                return $result;
            }
        }

        throw new RuntimeException('Unable to find corresponding renderer for inline type ' . get_class($inline));
    }

    /**
     * @param AbstractInline[] $inlines
     *
     * @return string
     */
    public function renderInlines(iterable $inlines): string
    {
        $result = [];

        foreach ($inlines as $inline) {
            $result[] = unserialize($this->renderInline($inline));
        }

        return serialize(array_flatten($result));
    }

    /**
     * @param AbstractBlock $block
     * @param bool $inTightList
     *
     * @return string
     * @throws RuntimeException
     *
     */
    public function renderBlock(AbstractBlock $block, $inTightList = false): string
    {
        $renderers = $this->environment->getBlockRenderersForClass(get_class($block));

        /** @var BlockRendererInterface $renderer */
        foreach ($renderers as $renderer) {
            if (($result = $renderer->render($block, $this, $inTightList)) !== null) {
                return $result;
            }
        }

        throw new RuntimeException('Unable to find corresponding renderer for block type ' . get_class($block));
    }

    /**
     * @param AbstractBlock[] $blocks
     * @param bool $inTightList
     *
     * @return string
     */
    public function renderBlocks($blocks, $inTightList = false): string
    {
        $result = [];
        foreach ($blocks as $block) {
            $result[] = unserialize($this->renderBlock($block, $inTightList));
        }

        return serialize(array_flatten($result));
    }
}
