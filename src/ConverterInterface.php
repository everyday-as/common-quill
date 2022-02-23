<?php

namespace Everyday\CommonQuill;

use Everyday\QuillDelta\Delta;

interface ConverterInterface
{
    /**
     * Converts CommonMark to Quill delta.
     *
     * @param string $commonMark
     *
     * @return Delta
     *
     * @api
     */
    public function convertToQuill(string $commonMark): Delta;
}
