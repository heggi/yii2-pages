<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\ElFinder;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;
use heggi\yii2files\widgets\SingleFileWidget;

/* @var $this yii\web\View */
/* @var $model heggi\yii2pages\models\Page */
/* @var $form yii\widgets\ActiveForm */

$module = Yii::$app->controller->module;
?>

<div class="row">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="col-xs-9">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'slug')->textInput([
                'maxlength' => true, 
                'readonly' => !$module->allowUpdateSlug && !$model->isNewRecord,
            ]) ?>

            <?php if($module->showExcerpt) : ?>
                <?= $form->field($model, 'excerpt')->textarea(['rows' => 6]) ?>
            <?php endif ?>

            <?php if($module->ckeditor === false) : ?>
                <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>
            <?php else : ?>
                <?= $form->field($model, 'content')->widget(CKEditor::className(), ArrayHelper::merge([
                    'options' => ['rows' => 6],
                    'clientOptions' => $module->elfinder ? ElFinder::ckeditorOptions('elfinder', is_array($module->elfinder)?$module->elfinder:[]) : [],
                ], $module->ckeditor))->label(false) ?>
            <?php endif ?>
        </div>
        <div class="col-xs-3">
            <?php if(!empty($module->categories)) : ?>
                <?= $form->field($model, 'category')->dropDownList(
                    ArrayHelper::getColumn($module->categories, 'label'), 
                    [
                        'disabled' => !$module->allowChangeCategory && !$model->isNewRecord
                    ]
                ) ?>
            <?php endif ?>

            <?= $form->field($model, "picture")->widget(SingleFileWidget::className(), [
                'key' => 'picture',
                'delete' => "deletePicture",
            ])->label('Изображения товара') ?>
            
            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>