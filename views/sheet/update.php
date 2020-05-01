<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Sheet */

$this->title = 'Update Sheet: ' . $model->sheet_id;
$this->params['breadcrumbs'][] = ['label' => 'Sheets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->sheet_id, 'url' => ['view', 'id' => $model->sheet_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sheet-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
