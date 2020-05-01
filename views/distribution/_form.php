<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Distribution */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="distribution-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'operation_id')->textInput() ?>

    <?= $form->field($model, 'dept_id')->textInput() ?>

    <?= $form->field($model, 'sub_cost')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sub_cost_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sub_fop')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sub_fop_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sub_other')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sub_other_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'version')->textInput() ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'operation_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
