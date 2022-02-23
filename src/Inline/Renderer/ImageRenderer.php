<?php

namespace Everyday\CommonQuill\Inline\Renderer;

use Everyday\QuillDelta\Delta;
use Everyday\QuillDelta\DeltaOp;
use InvalidArgumentException;
use League\CommonMark\Extension\CommonMark\Node\Inline\Image;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\RegexHelper;
use League\Config\ConfigurationAwareInterface;
use League\Config\ConfigurationInterface;

class ImageRenderer implements NodeRendererInterface, ConfigurationAwareInterface
{
    protected ConfigurationInterface $config;

    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        if (!($node instanceof Image)) {
            throw new InvalidArgumentException('Incompatible inline type: '.get_class($node));
        }

        $src = $node->getUrl();
        if (!$this->config->get('allow_unsafe_links') && RegexHelper::isLinkPotentiallyUnsafe($src)) {
            $src = '//:0';
        }

        $alt = new Delta(unserialize($childRenderer->renderNodes($node->children()), ['allowed_classes' => [DeltaOp::class]]));
        $alt = trim($alt->toPlaintext());

        $title = $node->data['title'] ?? null;

        return serialize(DeltaOp::embed('image', $src, compact('alt', 'title')));
    }

    public function setConfiguration(ConfigurationInterface $configuration): void
    {
        $this->config = $configuration;
    }
}
