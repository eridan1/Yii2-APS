<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\RegistrySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Registries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registry-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Registry', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'operation_id',
            'sheet_id',
            'service_id',
            'group_num',
            'time_start',
            //'time_end',
            //'input_cost',
            //'tax_rate',
            //'customer_type',
            //'hours',
            //'student_count',
            //'addition_notes',
            //'worker_fop',
            //'university_spends',
            //'u_spends_value',
            //'communal_spends',
            //'c_spends_value',
            //'fop_spends',
            //'f_spends_value',
            //'fop_staffer',
            //'fop_staffer_value',
            //'material_costs',
            //'material_costs_value',
            //'capital_costs',
            //'capital_costs_value',
            //'univ_clinic_costs',
            //'univ_clinic_costs_value',
            //'direct_spends',
            //'version',
            //'username',
            //'operation_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
