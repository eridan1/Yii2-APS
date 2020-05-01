<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Dept */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dept-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dept_id')->textInput() ?>

    <?= $form->field($model, 'parent_dept_id')->textInput() ?>

    <?= $form->field($model, 'pressmark')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dept_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dept_abbreviate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_sub_exists')->textInput() ?>

    <?= $form->field($model, 'sheet_type')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
