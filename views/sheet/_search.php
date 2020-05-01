<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SheetSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sheet-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'sheet_id') ?>

    <?= $form->field($model, 'dept_id') ?>

    <?= $form->field($model, 'sheet_time_start') ?>

    <?= $form->field($model, 'sheet_time_end') ?>

    <?= $form->field($model, 'sheet_notes') ?>

    <?php // echo $form->field($model, 'sheet_state') ?>

    <?php // echo $form->field($model, 'version') ?>

    <?php // echo $form->field($model, 'username') ?>

    <?php // echo $form->field($model, 'operation_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
