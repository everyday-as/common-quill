<?php

namespace Everyday\CommonQuill\Block\Renderer;

use Everyday\QuillDelta\DeltaOp;
use InvalidArgumentException;
use League\CommonMark\Node\Block\Document;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\Config\ConfigurationAwareInterface;
use League\Config\ConfigurationInterface;

class DocumentRenderer implements NodeRendererInterface, ConfigurationAwareInterface
{
    protected ConfigurationInterface $config;

    public function render(Node $node, ChildNodeRendererInterface $childRenderer): string
    {
        if (!($node instanceof Document)) {
            throw new InvalidArgumentException('Incompatible block type: '.get_class($node));
        }

        $ops = unserialize($childRenderer->renderNodes($node->children()), [
            'allowed_classes' => [DeltaOp::class],
        ]);

        if (!empty($ops) && !$ops[0]->isEmbed() && !$ops[0]->isBlockModifier()) {
            $ops[0]->setInsert(ltrim($ops[0]->getInsert()));
        }

        return serialize($ops);
    }

    public function setConfiguration(ConfigurationInterface $configuration): void
    {
        $this->config = $configuration;
    }
}
