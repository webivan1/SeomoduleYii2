<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 23.10.2017
 * Time: 21:43
 */

namespace webivan\seomodule\connects;

interface IConnects
{
    /**
     * Start sctipt
     *
     * @param bool $dev
     * @return array|\Generator
     */
    public function run($dev = false);
}