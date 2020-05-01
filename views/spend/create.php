<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Spend */

$this->title = 'Create Spend';
$this->params['breadcrumbs'][] = ['label' => 'Spends', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spend-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
