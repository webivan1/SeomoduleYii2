<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 24.10.2017
 * Time: 22:02
 */

namespace webivan\seomodule\templaters\twig;

use webivan\seomodule\helpers\Text;

class TwigFunctions extends \Twig_Extension
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('declensionWords', [$this, 'getDeclensionWords']),
            new \Twig_SimpleFunction('shortPrice', [$this, 'getShortPrice']),
        ];
    }

    public function getDeclensionWords($num, $declension)
    {
        return Text::declensionWords($num, $declension);
    }

    public function getShortPrice($price)
    {
        return Text::shortPrice($price);
    }
}