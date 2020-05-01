<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SpendSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="spend-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'spend_id') ?>

    <?= $form->field($model, 'operation_id') ?>

    <?= $form->field($model, 'spend_type') ?>

    <?= $form->field($model, 'spend_cost') ?>

    <?= $form->field($model, 'version') ?>

    <?php // echo $form->field($model, 'username') ?>

    <?php // echo $form->field($model, 'operation_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
