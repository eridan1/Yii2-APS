<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RegistrySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="registry-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'operation_id') ?>

    <?= $form->field($model, 'sheet_id') ?>

    <?= $form->field($model, 'service_id') ?>

    <?= $form->field($model, 'group_num') ?>

    <?= $form->field($model, 'time_start') ?>

    <?php // echo $form->field($model, 'time_end') ?>

    <?php // echo $form->field($model, 'input_cost') ?>

    <?php // echo $form->field($model, 'tax_rate') ?>

    <?php // echo $form->field($model, 'customer_type') ?>

    <?php // echo $form->field($model, 'hours') ?>

    <?php // echo $form->field($model, 'student_count') ?>

    <?php // echo $form->field($model, 'addition_notes') ?>

    <?php // echo $form->field($model, 'worker_fop') ?>

    <?php // echo $form->field($model, 'university_spends') ?>

    <?php // echo $form->field($model, 'u_spends_value') ?>

    <?php // echo $form->field($model, 'communal_spends') ?>

    <?php // echo $form->field($model, 'c_spends_value') ?>

    <?php // echo $form->field($model, 'fop_spends') ?>

    <?php // echo $form->field($model, 'f_spends_value') ?>

    <?php // echo $form->field($model, 'fop_staffer') ?>

    <?php // echo $form->field($model, 'fop_staffer_value') ?>

    <?php // echo $form->field($model, 'material_costs') ?>

    <?php // echo $form->field($model, 'material_costs_value') ?>

    <?php // echo $form->field($model, 'capital_costs') ?>

    <?php // echo $form->field($model, 'capital_costs_value') ?>

    <?php // echo $form->field($model, 'univ_clinic_costs') ?>

    <?php // echo $form->field($model, 'univ_clinic_costs_value') ?>

    <?php // echo $form->field($model, 'direct_spends') ?>

    <?php // echo $form->field($model, 'version') ?>

    <?php // echo $form->field($model, 'username') ?>

    <?php // echo $form->field($model, 'operation_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
