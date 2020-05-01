<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SheetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sheets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sheet-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Sheet', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'sheet_id',
            'dept_id',
            'sheet_time_start',
            'sheet_time_end',
            'sheet_notes',
            //'sheet_state',
            //'version',
            //'username',
            //'operation_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
