<?php
/**
 * Created by PhpStorm.
 * User: jojop
 * Date: 25/02/2019
 * Time: 22:25
 */

namespace Everyday\CommonQuill;


interface ConverterInterface
{
    /**
     * Converts CommonMark to Quill delta.
     *
     * @param string $commonMark
     *
     * @return string HTML
     *
     * @api
     */
    public function convertToQuill($commonMark);
}
