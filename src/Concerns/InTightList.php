<?php

namespace Everyday\CommonQuill\Concerns;

use League\CommonMark\Node\Block\TightBlockInterface;
use League\CommonMark\Node\Node;

trait InTightList
{
    private function inTightList(Node $node): bool
    {
        // Only check up to two (2) levels above this for tightness
        $i = 2;
        while (($node = $node->parent()) && $i--) {
            if ($node instanceof TightBlockInterface) {
                return $node->isTight();
            }
        }

        return false;
    }
}
