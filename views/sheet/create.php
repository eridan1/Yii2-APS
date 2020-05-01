<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Sheet */

$this->title = 'Create Sheet';
$this->params['breadcrumbs'][] = ['label' => 'Sheets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sheet-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
