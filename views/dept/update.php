<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dept */

$this->title = 'Update Dept: ' . $model->dept_id;
$this->params['breadcrumbs'][] = ['label' => 'Depts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->dept_id, 'url' => ['view', 'id' => $model->dept_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dept-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
