<?php

namespace Everyday\CommonQuill;

use Everyday\CommonQuill\Exceptions\RuntimeException;
use Everyday\QuillDelta\DeltaOp;
use League\CommonMark\Environment\EnvironmentInterface;
use League\CommonMark\Node\Block\Document;
use League\CommonMark\Node\Node;
use League\CommonMark\Output\RenderedContent;
use League\CommonMark\Output\RenderedContentInterface;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\MarkdownRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use function get_class;

class QuillRenderer implements MarkdownRendererInterface, ChildNodeRendererInterface
{
    public function __construct(protected EnvironmentInterface $environment)
    {
    }

    public function renderDocument(Document $document): RenderedContentInterface
    {
        return new RenderedContent($document, $this->renderNode($document));
    }

    public function renderNodes(iterable $nodes): string
    {
        $result = [];
        foreach ($nodes as $node) {
            $result[] = unserialize($this->renderNode($node), [
                'allowed_classes' => [DeltaOp::class]
            ]);
        }

        return serialize(array_flatten($result));
    }

    public function renderNode(Node $node)
    {
        $renderers = $this->environment->getRenderersForClass(get_class($node));

        foreach ($renderers as $renderer) {
            assert($renderer instanceof NodeRendererInterface);
            if (($result = $renderer->render($node, $this)) !== null) {
                return $result;
            }
        }

        throw new RuntimeException('Unable to find corresponding renderer for node type: ' . get_class($node));
    }

    public function getBlockSeparator(): string
    {
        return '';
    }

    public function getInnerSeparator(): string
    {
        return '';
    }
}
