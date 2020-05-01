<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Registry */

$this->title = $model->operation_id;
$this->params['breadcrumbs'][] = ['label' => 'Registries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="registry-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->operation_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->operation_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'operation_id',
            'sheet_id',
            'service_id',
            'group_num',
            'time_start',
            'time_end',
            'input_cost',
            'tax_rate',
            'customer_type',
            'hours',
            'student_count',
            'addition_notes',
            'worker_fop',
            'university_spends',
            'u_spends_value',
            'communal_spends',
            'c_spends_value',
            'fop_spends',
            'f_spends_value',
            'fop_staffer',
            'fop_staffer_value',
            'material_costs',
            'material_costs_value',
            'capital_costs',
            'capital_costs_value',
            'univ_clinic_costs',
            'univ_clinic_costs_value',
            'direct_spends',
            'version',
            'username',
            'operation_date',
        ],
    ]) ?>

</div>
