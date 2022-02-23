<?php

namespace Everyday\CommonQuill\Inline\Renderer;

use Everyday\QuillDelta\DeltaOp;
use InvalidArgumentException;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\RegexHelper;
use League\Config\ConfigurationAwareInterface;
use League\Config\ConfigurationInterface;

class LinkRenderer implements NodeRendererInterface, ConfigurationAwareInterface
{
    protected ConfigurationInterface $config;

    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        if (!($node instanceof Link)) {
            throw new InvalidArgumentException('Incompatible inline type: ' . get_class($node));
        }

        $target = $node->data['attributes']['target'] ?? null;

        $link = $node->getUrl();
        if (!$this->config->get('allow_unsafe_links') && RegexHelper::isLinkPotentiallyUnsafe($link)) {
            $link = 'about:blank';
        }

        /** @var DeltaOp[] $ops */
        $ops = unserialize($childRenderer->renderNodes($node->children()), [
            'allowed_classes' => [DeltaOp::class]
        ]);

        DeltaOp::applyAttributes($ops, compact('link', 'target'));

        return serialize($ops);
    }

    public function setConfiguration(ConfigurationInterface $configuration): void
    {
        $this->config = $configuration;
    }
}
