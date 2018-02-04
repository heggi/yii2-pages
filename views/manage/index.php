<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Страницы';
$this->params['breadcrumbs'][] = $this->title;

$module = Yii::$app->controller->module;
?>
<div class="page-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <?php if($module->allowCreate) : ?>
    <p>
        <?= Html::a('Добавить страницу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute' => 'title',
                'content' => function($data) {
                    return Html::a($data->title, ['view', 'id' => $data->id]);
                },
            ],
            'slug',
            [
                'attribute' => 'category',
                'visible' => count($module->categories) > 0,
                'content' => function($data) use ($module) {
                    return ArrayHelper::getValue($module->categories, $data->category)['label'];
                },
            ],
            //'content:ntext',
            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => [
                    'view' => false,
                    'update' => true,
                    'delete' => $module->allowDelete,
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
