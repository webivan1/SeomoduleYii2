<?php
/**
 * Created by PhpStorm.
 * User: maltsev
 * Date: 23.10.2017
 * Time: 17:06
 */

namespace webivan\seomodule\assets;

use yii\web\AssetBundle;
use yii\web\View;

class AppAsset extends AssetBundle
{
    public $sourcePath = '@seomodule/frontend';

    public $css = [
        'css/bs.paper.css',
        'css/main.css',
        '//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/default.min.css',
    ];

    public $js = [
        '//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js',
        'js/gridFunctions.js'
    ];

    public $jsOptions = [
        'position' => View::POS_HEAD
    ];

    public $depends = [
        \yii\web\JqueryAsset::class,
        \yii\bootstrap\BootstrapAsset::class,
        \yii\bootstrap\BootstrapPluginAsset::class,
        //\yii\bootstrap\BootstrapThemeAsset::class,
        \yii\web\YiiAsset::class
    ];
}