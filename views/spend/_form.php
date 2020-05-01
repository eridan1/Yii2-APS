<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Spend */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="spend-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'operation_id')->textInput() ?>

    <?= $form->field($model, 'spend_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'spend_cost')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'version')->textInput() ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'operation_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
