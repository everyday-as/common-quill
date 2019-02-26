<?php

namespace Everyday\CommonQuill;

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
    public function convertToQuill($commonMark);
}
