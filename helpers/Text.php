<?php
/**
 * Created by PhpStorm.
 * User: maltsev
 * Date: 24.10.2017
 * Time: 15:59
 */

namespace webivan\seomodule\helpers;

use Yii;

class Text
{
    /**
     * Text::declensionWords(1, array('стройка', 'стройки', 'строек'))
     *
     * @param $number
     * @param array $suffix
     * @return mixed
     */
    public static function declensionWords($number, $suffix = [])
    {
        $keys = [2, 0, 1, 1, 1, 2];
        $mod = $number % 100;
        $suffix_key = ($mod > 7 && $mod < 20) ? 2 : $keys[min($mod % 10, 5)];
        return $suffix[$suffix_key];
    }

    /**
     * Сокращает цену до млн. рублей
     *
     * @param number $price
     * @return array
     */
    public static function shortPrice($price, $keyShortStrings = [])
    {
        $keyShortStrings = empty($keyShortStrings) ? [2 => 'тыс', 3 => 'млн', 4 => 'млрд'] : $keyShortStrings;
        $shortPriceArray = explode('.', number_format($price, 0, ',', '.'));

        $shortPrice = strlen($shortPriceArray[0]) >= 3 ? $shortPriceArray[0] : round($shortPriceArray[0] . (
            isset($shortPriceArray[1]) ? '.' . $shortPriceArray[1] : null
        ), 1);

        return [
            'price' => $shortPrice,
            'text' => isset($keyShortStrings[count($shortPriceArray)])
                ? $keyShortStrings[count($shortPriceArray)]
                : null
        ];
    }
}