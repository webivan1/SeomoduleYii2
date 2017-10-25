<?php
/**
 * Created by PhpStorm.
 * User: maltsev
 * Date: 23.10.2017
 * Time: 16:37
 */

use yii\helpers\Html;
use webivan\seomodule\assets\AppAsset;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use webivan\seomodule\helpers\Url;

$bundle = AppAsset::register($this);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="referrer" content="always">

    <?= Html::csrfMetaTags() ?>

    <title><?= Html::encode($this->title) ?></title>

    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?php NavBar::begin([
    'brandLabel' => 'Seomodule',
    'brandUrl' => 'https://github.com/webivan1/SeomoduleYii2',
    'brandOptions' => [
        'target' => '_blank'
    ],
    'options' => [
        'class' => 'navbar navbar-default navbar-static-top'
    ]
]) ?>

<?= Nav::widget([
    'items' => [
        [
            'label' => 'Home',
            'url' => Url::to('/'),
            'active' => Yii::$app->controller->action->id === 'welcome'
        ],
        [
            'label' => 'List',
            'url' => Url::to('/default/index'),
            'active' => Yii::$app->controller->action->id === 'index'
        ],
    ],
    'options' => ['class' => 'navbar-nav'],
]) ?>

<?php NavBar::end() ?>

<div class="container">
    <?php if (Yii::$app->session->hasFlash('success')) : ?>
        <div class="alert alert-success">
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    <?= $content ?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
