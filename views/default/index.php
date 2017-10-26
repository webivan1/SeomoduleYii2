<?php
/**
 * Created by PhpStorm.
 * User: maltsev
 * Date: 23.10.2017
 * Time: 16:37
 */

use yii\grid\GridView;
use webivan\seomodule\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\Html;

$this->title = 'Все конфиги';

?>

<h1><?= $this->title ?></h1>

<div class="panel">
    <div class="panel-body text-right">
        <a class="btn btn-primary" href="<?= Url::to('/default/create') ?>">
            Добавить новый
        </a>
    </div>
</div>

<?php Pjax::begin() ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $model,
    'tableOptions' => ['class' => 'table'],
    'columns' => [
        'id',
        'source',
        'connect',
        [
            'attribute' => 'templater',
            'filter' => Yii::$app->params['webivan@seomodule']['filterTemplater']
        ],
        [
            'attribute' => 'count_seo',
            'format' => 'html',
            'value' => function ($data) {
                return Html::tag('b', $data->count_seo, [
                    'class' => $data->count_seo > 0 ? 'text-success' : 'text-danger'
                ]);
            }
        ],
        [
            'attribute' => 'run_date',
            'filter' => false,
            'value' => function ($data) {
                return is_null($data->run_date) ? 'Не запускался' : date('d.m.Y H:i', strtotime($data->run_date));
            },
        ],
        [
            'attribute' => 'state',
            'filter' => [
                1 => 'disabled',
                2 => 'active'
            ],
            'format' => 'html',
            'value' => function ($data) {
                return Html::tag('span', $data->state == 2 ? 'Active' : 'Disabled', [
                    'class' => 'label label-' . ($data->state == 2 ? 'success' : 'danger')
                ]);
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}',
        ],
    ],
]) ?>

<?php Pjax::end() ?>
