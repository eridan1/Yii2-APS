<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Distribution */

$this->title = 'Update Distribution: ' . $model->distribution_id;
$this->params['breadcrumbs'][] = ['label' => 'Distributions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->distribution_id, 'url' => ['view', 'id' => $model->distribution_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="distribution-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
