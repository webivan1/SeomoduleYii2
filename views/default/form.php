<?php
/**
 * Created by PhpStorm.
 * User: maltsev
 * Date: 24.10.2017
 * Time: 10:36
 */

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use webivan\seomodule\models\ItemsSeoMetatags;
use webivan\seomodule\models\ItemsObjectText;
use webivan\seomodule\assets\AppAsset;
use yii\web\View;

$this->title = $model->isNewRecord ? 'Добавить seo config' : 'Обновить config #' . $model->id;

$modelSeo = new ItemsSeoMetatags();
$modelObject = new ItemsObjectText();

$objectTexts = [];

if (!$model->isNewRecord || Yii::$app->request->isPost) {
    if (is_string($model->meta_template)) {
        $model->meta_template = Json::decode($model->meta_template, true);
    }

    if (!empty($model->meta_template['object_text']) && isset($model->meta_template['object_text']['key'])) {
        $model->meta_template = array_merge($model->meta_template, [
            'object_text' => ItemsObjectText::compactArrayObjectText(
                $model->meta_template['object_text']
            )
        ]);
    }
}

$assetUrl = Yii::$app->getAssetManager()->publish('@seomodule/frontend/js');
$this->registerJsFile($assetUrl[1] . '/main.js', ['position' => View::POS_BEGIN]);

?>

<h1><?= $this->title ?></h1>

<div class="grid-connect-keys"></div>

<?php $form = ActiveForm::begin([
    'id' => 'AddNewConfig'
]) ?>

<h3>Основные настройки</h3>

<code>
    Главные настройки, укажите шаблон - есть описание про шаблонизаторы.
    Укажите source для идентификации сео текстов.
    Выберите нужный коннект - как настроить коннекс смотрите в документации.
</code>

<hr />

<div class="panel">
    <div class="panel-body">
        <?php
            if ($model->hasErrors()) {
                echo Html::errorSummary($model, ['class' => 'alert alert-danger']);
            }
        ?>

        <?= $form->field($model, 'templater')->dropDownList($params['filterTemplater']) ?>

        <?= $form->field($model, 'source')->textInput() ?>

        <?= $form->field($model, 'connect')->dropDownList($dropDownConnect, [
            'prompt' => 'Select'
        ]) ?>

        <?= $form->field($model, 'state')->dropDownList([
            1 => 'disabled',
            2 => 'active'
        ], [
            'prompt' => 'Select status'
        ]) ?>
    </div>
</div>

<h3>Meta tags</h3>

<code>
    Опишите все возможные мета теги используя данные из коннекта
</code>

<hr />

<div class="panel">
    <div class="panel-body">
        <?php foreach ($modelSeo->getAttributes() as $key => $value) : ?>

            <?php if ($key === 'object_text') continue; ?>

            <?php
                $errorKey = "meta_template.$key";
                $hasError = $model->hasErrors($errorKey);

                $value = !empty($model->meta_template[$key])
                    ? (empty($model->meta_template[$key]) ? null : $model->meta_template[$key])
                    : null;

                echo Html::tag('div',
                    Html::activeLabel($modelSeo, $key, ['class' => 'control-label']) .
                    Html::activeTextarea($model, "meta_template[$key]", [
                        'value' => $value,
                        'class' => 'form-control',
                        'onkeyup' => "$(this).parent().removeClass('has-error')"
                    ]) .
                    Html::tag('div', Html::error($model, "meta_template.$key"), ['class' => 'help-block'])
                , ['class' => 'form-group ' . ($hasError ? 'has-error' : '')]);
            ?>

        <?php endforeach; ?>
    </div>
</div>

<h3>Добавить Object texts</h3>

<code>
    Дополнительные мета теги с произвольным key
</code>

<hr />

<div class="js-clone-container">
    <?php if (!empty($model->meta_template['object_text']) && is_array($model->meta_template['object_text'])) : ?>

        <?php $i= 0; foreach ($model->meta_template['object_text'] as $key => $value) : ?>

            <div class="js-clone-item panel">
                <div class="panel-body">
                    <?php
                        $errorKey = "meta_template.object_text.$i.key";
                        $hasError = $model->hasErrors($errorKey);

                        echo Html::tag('div',
                            Html::activeLabel($modelObject, 'key', ['class' => 'control-label']) .
                            Html::activeTextarea($model, "meta_template[object_text][key][]", [
                                'value' => $key,
                                'class' => 'form-control',
                                'onkeyup' => "$(this).parent().removeClass('has-error')"
                            ]) .
                            Html::tag('div', Html::error($model, $errorKey), ['class' => 'help-block'])
                        , ['class' => 'form-group ' . ($hasError ? 'has-error' : '')]);
                    ?>

                    <?php
                        $errorKey = "meta_template.object_text.$i.value";
                        $hasError = $model->hasErrors($errorKey);

                        echo Html::tag('div',
                            Html::activeLabel($modelObject, 'value', ['class' => 'control-label']) .
                            Html::activeTextarea($model, "meta_template[object_text][value][]", [
                                'value' => $value,
                                'class' => 'form-control',
                                'onkeyup' => "$(this).parent().removeClass('has-error')"
                            ]) .
                            Html::tag('div', Html::error($model, $errorKey), ['class' => 'help-block'])
                        , ['class' => 'form-group ' . ($hasError ? 'has-error' : '')]);
                    ?>
                </div>
            </div>

            <?php $i++; endforeach; ?>

    <?php else : ?>

        <div class="js-clone-item panel">
            <div class="panel-body">
                <?=
                    $form
                        ->field($model, 'meta_template[object_text][key][]')
                        ->textInput()
                        ->label($modelObject->getAttributeLabel('key'));
                ?>

                <?=
                    $form
                        ->field($model, 'meta_template[object_text][value][]')
                        ->textarea()
                        ->label($modelObject->getAttributeLabel('value'));
                ?>
            </div>
        </div>

    <?php endif; ?>
</div>

<div class="form-group">
    <button type="button" class="btn btn-link js-add-object">
        Add object text +
    </button>
</div>

<div class="panel">
    <div class="panel-body">
        <div class="text-right">
            <button class="btn btn-success">
                <?= $model->isNewRecord ? 'Добавить' : 'Обновить' ?>
            </button>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

