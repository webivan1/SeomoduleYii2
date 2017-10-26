<?php
/**
 * Created by PhpStorm.
 * User: maltsev
 * Date: 26.10.2017
 * Time: 15:37
 */

use yii\web\View;
use yii\bootstrap\Tabs;
use webivan\seomodule\helpers\Url;

$this->registerJs('
    hljs.initHighlightingOnLoad();
    
    $(function () {
        $(\'div.code-vis\').each(function(i, block) {
          hljs.highlightBlock(block);
        });
    });
', View::POS_READY);

echo Tabs::widget([
    'items' => [
        [
            'label' => 'Что такое коннект?',
            'url' => Url::to('/docs'),
            'active' => Yii::$app->controller->action->id === 'index'
        ],
        [
            'label' => 'Что такое сео конфиг',
            'url' => Url::to('/docs/config'),
            'active' => Yii::$app->controller->action->id === 'config'
        ],
        [
            'label' => 'Как запустить сео конфиг?',
            'url' => Url::to('/docs/run-config'),
            'active' => Yii::$app->controller->action->id === 'run-config'
        ],
        [
            'label' => 'Как достать мета теги?',
            'url' => Url::to('/docs/metatags'),
            'active' => Yii::$app->controller->action->id === 'metatags'
        ],
    ],
]);
