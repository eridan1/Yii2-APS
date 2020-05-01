<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DeptSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dept-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'dept_id') ?>

    <?= $form->field($model, 'parent_dept_id') ?>

    <?= $form->field($model, 'pressmark') ?>

    <?= $form->field($model, 'dept_name') ?>

    <?= $form->field($model, 'dept_abbreviate') ?>

    <?php // echo $form->field($model, 'is_sub_exists') ?>

    <?php // echo $form->field($model, 'sheet_type') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
