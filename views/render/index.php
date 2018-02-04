<?php

use yii\helpers\Html;

$this->title = $model->title;
$this->params['breadcrumbs'][] = $model->title;

?>
<div class="page-index">
    <h1><?= Html::encode($model->title) ?></h1>
    <div class="content"><?= $model->content ?></div>
</div>
