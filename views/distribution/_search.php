<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DistributionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="distribution-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'distribution_id') ?>

    <?= $form->field($model, 'operation_id') ?>

    <?= $form->field($model, 'dept_id') ?>

    <?= $form->field($model, 'sub_cost') ?>

    <?= $form->field($model, 'sub_cost_value') ?>

    <?php // echo $form->field($model, 'sub_fop') ?>

    <?php // echo $form->field($model, 'sub_fop_value') ?>

    <?php // echo $form->field($model, 'sub_other') ?>

    <?php // echo $form->field($model, 'sub_other_value') ?>

    <?php // echo $form->field($model, 'version') ?>

    <?php // echo $form->field($model, 'username') ?>

    <?php // echo $form->field($model, 'operation_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
