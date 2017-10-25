<?php
/**
 * Created by PhpStorm.
 * User: maltsev
 * Date: 24.10.2017
 * Time: 16:43
 */

namespace webivan\seomodule\templaters;

interface ITemplater
{
    /**
     * start templater
     *
     * @param string $text
     * @param string $key
     * @return string
     */
    public function parseText($text, $key);
}