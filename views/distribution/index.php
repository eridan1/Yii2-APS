<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\DistributionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Distributions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="distribution-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Distribution', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'distribution_id',
            'operation_id',
            'dept_id',
            'sub_cost',
            'sub_cost_value',
            //'sub_fop',
            //'sub_fop_value',
            //'sub_other',
            //'sub_other_value',
            //'version',
            //'username',
            //'operation_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
