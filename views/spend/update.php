<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Spend */

$this->title = 'Update Spend: ' . $model->spend_id;
$this->params['breadcrumbs'][] = ['label' => 'Spends', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->spend_id, 'url' => ['view', 'id' => $model->spend_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="spend-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
