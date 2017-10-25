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

$this->title = $model->isNewRecord ? 'Add seo config' : 'Edit config #' . $model->id;

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

?>

<h1><?= $this->title ?></h1>

<div class="grid-connect-keys"></div>

<div class="panel">
    <div class="panel-body">
        <?php $form = ActiveForm::begin([
            'id' => 'AddNewConfig'
        ]) ?>

            <?php
                if ($model->hasErrors()) {
                    echo Html::errorSummary($model, ['class' => 'alert alert-danger']);
                }
            ?>

            <?= $form->field($model, 'templater')->dropDownList($params['filterTemplater']) ?>

            <?= $form->field($model, 'source')->textInput() ?>

            <?= $form->field($model, 'connect')->dropDownList($dropDownConnect, [
                'prompt' => 'Not connect'
            ]) ?>

            <?= $form->field($model, 'state')->dropDownList([
                1 => 'disabled',
                2 => 'active'
            ], [
                'prompt' => 'Select status'
            ]) ?>

            <h3>Meta tags</h3>
            <hr />

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

            <h3>Add Object texts</h3>
            <hr />

            <div class="js-clone-container">
                <?php if (!empty($model->meta_template['object_text']) && is_array($model->meta_template['object_text'])) : ?>

                    <?php foreach ($model->meta_template['object_text'] as $key => $value) : ?>

                        <div class="js-clone-item">

                            <?=
                                $form
                                    ->field($model, 'meta_template[object_text][key][]')
                                    ->textInput(['value' => $key])
                                    ->label($modelObject->getAttributeLabel('key'));
                            ?>

                            <?=
                                $form
                                    ->field($model, 'meta_template[object_text][value][]')
                                    ->textarea(['value' => $value])
                                    ->label($modelObject->getAttributeLabel('value'));
                            ?>

                            <hr />
                        </div>

                    <?php endforeach; ?>

                <?php else : ?>

                    <div class="js-clone-item">

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

                        <hr />
                    </div>

                <?php endif; ?>
            </div>

            <div>
                <button type="button" class="btn btn-primary js-add-object">
                    Add object text
                </button>
            </div>

            <div class="text-right">
                <button class="btn btn-success">
                    <?= $model->isNewRecord ? 'Add' : 'Edit' ?>
                </button>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

