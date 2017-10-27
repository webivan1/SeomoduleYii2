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
            'label' => 'Коннекты',
            'url' => Url::to('/docs'),
            'active' => Yii::$app->controller->action->id === 'index'
        ],
        [
            'label' => 'Шаблонизаторы',
            'url' => Url::to('/docs/templaters'),
            'active' => Yii::$app->controller->action->id === 'templaters'
        ],
        [
            'label' => 'Сео конфиги',
            'url' => Url::to('/docs/config'),
            'active' => Yii::$app->controller->action->id === 'config'
        ],
        [
            'label' => 'Запуск сео конфига',
            'url' => Url::to('/docs/run-config'),
            'active' => Yii::$app->controller->action->id === 'run-config'
        ],
        [
            'label' => 'Использование на проекте',
            'url' => Url::to('/docs/metatags'),
            'active' => Yii::$app->controller->action->id === 'metatags'
        ],
    ],
]);
