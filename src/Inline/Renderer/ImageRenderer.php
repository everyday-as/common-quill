<?php

namespace Everyday\CommonQuill\Inline\Renderer;

use Everyday\QuillDelta\Delta;
use Everyday\QuillDelta\DeltaOp;
use InvalidArgumentException;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Element\Image;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;
use League\CommonMark\Util\ConfigurationAwareInterface;
use League\CommonMark\Util\ConfigurationInterface;
use League\CommonMark\Util\RegexHelper;

class ImageRenderer implements InlineRendererInterface, ConfigurationAwareInterface
{
    /**
     * @var ConfigurationInterface
     */
    protected $config;

    /**
     * @param AbstractInline           $inline
     * @param ElementRendererInterface $quillRenderer
     *
     * @return string
     */
    public function render(AbstractInline $inline, ElementRendererInterface $quillRenderer)
    {
        if (!($inline instanceof Image)) {
            throw new InvalidArgumentException('Incompatible inline type: '.get_class($inline));
        }

        $src = $inline->getUrl();
        if (!$this->config->get('allow_unsafe_links') && RegexHelper::isLinkPotentiallyUnsafe($src)) {
            $src = '//:0';
        }

        $alt = new Delta(unserialize($quillRenderer->renderInlines($inline->children())));
        $alt = trim($alt->toPlaintext());

        $title = $inline->data['title'] ?? null;

        return serialize(DeltaOp::embed('image', $src, compact('alt', 'title')));
    }

    /**
     * @param ConfigurationInterface $configuration
     */
    public function setConfiguration(ConfigurationInterface $configuration)
    {
        $this->config = $configuration;
    }
}
