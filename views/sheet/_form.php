<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Sheet */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sheet-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dept_id')->textInput() ?>

    <?= $form->field($model, 'sheet_time_start')->textInput() ?>

    <?= $form->field($model, 'sheet_time_end')->textInput() ?>

    <?= $form->field($model, 'sheet_notes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sheet_state')->textInput() ?>

    <?= $form->field($model, 'version')->textInput() ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'operation_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
