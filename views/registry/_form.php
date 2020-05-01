<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Registry */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="registry-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sheet_id')->textInput() ?>

    <?= $form->field($model, 'service_id')->textInput() ?>

    <?= $form->field($model, 'group_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'time_start')->textInput() ?>

    <?= $form->field($model, 'time_end')->textInput() ?>

    <?= $form->field($model, 'input_cost')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tax_rate')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hours')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'student_count')->textInput() ?>

    <?= $form->field($model, 'addition_notes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'worker_fop')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'university_spends')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'u_spends_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'communal_spends')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'c_spends_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fop_spends')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'f_spends_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fop_staffer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fop_staffer_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'material_costs')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'material_costs_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'capital_costs')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'capital_costs_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'univ_clinic_costs')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'univ_clinic_costs_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'direct_spends')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'version')->textInput() ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'operation_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
