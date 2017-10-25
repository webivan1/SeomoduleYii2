<?php
/**
 * Created by PhpStorm.
 * User: maltsev
 * Date: 23.10.2017
 * Time: 17:28
 */

namespace webivan\seomodule\helpers;

use Yii;
use yii\helpers\Url as Base;

class Url extends Base
{
    /**
     * @inheritdoc
     */
    public static function to($url = '', $scheme = false)
    {
        $url = parent::to($url, $scheme);
        $url = '/' . Yii::$app->controller->module->id . '/' . ltrim($url, '/');

        return rtrim($url, '/');
    }
}