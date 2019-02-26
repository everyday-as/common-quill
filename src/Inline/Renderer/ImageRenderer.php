<?php

namespace Everyday\CommonQuill\Inline\Renderer;

use Everyday\CommonQuill\Delta;
use Everyday\CommonQuill\DeltaOp;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Element\Image;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;
use League\CommonMark\Util\Configuration;
use League\CommonMark\Util\ConfigurationAwareInterface;
use League\CommonMark\Util\RegexHelper;

class ImageRenderer implements InlineRendererInterface, ConfigurationAwareInterface
{
    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @param Image                               $inline
     * @param \Everyday\CommonQuill\QuillRenderer $quillRenderer
     *
     * @return DeltaOp
     */
    public function render(AbstractInline $inline, ElementRendererInterface $quillRenderer)
    {
        if (!($inline instanceof Image)) {
            throw new \InvalidArgumentException('Incompatible inline type: '.get_class($inline));
        }

        $src = $inline->getUrl();
        if (!$this->config->getConfig('allow_unsafe_links') && RegexHelper::isLinkPotentiallyUnsafe($src)) {
            $src = '//:0';
        }

        $alt = new Delta($quillRenderer->renderInlines($inline->children()));
        $alt = trim($alt->toPlaintext());

        $title = $inline->data['title'] ?? null;

        return DeltaOp::embed('image', $src, compact('alt', 'title'));
    }

    /**
     * @param Configuration $configuration
     */
    public function setConfiguration(Configuration $configuration)
    {
        $this->config = $configuration;
    }
}
