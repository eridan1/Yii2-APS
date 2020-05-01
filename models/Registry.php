<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%Registry}}".
 *
 * @property int $operation_id
 * @property int $sheet_id
 * @property int $service_id
 * @property string $group_num
 * @property string $time_start
 * @property string $time_end
 * @property string $input_cost
 * @property string $tax_rate
 * @property string $customer_type
 * @property string $hours
 * @property int $student_count
 * @property string $addition_notes
 * @property string $worker_fop
 * @property string $university_spends
 * @property string $u_spends_value
 * @property string $communal_spends
 * @property string $c_spends_value
 * @property string $fop_spends
 * @property string $f_spends_value
 * @property string $fop_staffer
 * @property string $fop_staffer_value
 * @property string $material_costs
 * @property string $material_costs_value
 * @property string $capital_costs
 * @property string $capital_costs_value
 * @property string $univ_clinic_costs
 * @property string $univ_clinic_costs_value
 * @property string $direct_spends
 * @property int $version
 * @property string $username
 * @property string $operation_date
 *
 * @property Distribution[] $distributions
 * @property Service $service
 * @property Sheet $sheet
 * @property Spend[] $spends
 */
class Registry extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%Registry}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sheet_id', 'service_id', 'student_count', 'version'], 'integer'],
            [['time_start', 'time_end', 'operation_date'], 'safe'],
            [['input_cost', 'customer_type', 'worker_fop', 'university_spends', 'communal_spends', 'fop_spends', 'fop_staffer', 'material_costs', 'capital_costs', 'univ_clinic_costs', 'username', 'operation_date'], 'required'],
            [['input_cost', 'tax_rate', 'hours', 'worker_fop', 'university_spends', 'u_spends_value', 'communal_spends', 'c_spends_value', 'fop_spends', 'f_spends_value', 'fop_staffer', 'fop_staffer_value', 'material_costs', 'material_costs_value', 'capital_costs', 'capital_costs_value', 'univ_clinic_costs', 'univ_clinic_costs_value', 'direct_spends'], 'number'],
            [['group_num', 'username'], 'string', 'max' => 50],
            [['customer_type'], 'string', 'max' => 100],
            [['addition_notes'], 'string', 'max' => 200],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => Service::className(), 'targetAttribute' => ['service_id' => 'service_id']],
            [['sheet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sheet::className(), 'targetAttribute' => ['sheet_id' => 'sheet_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'operation_id' => 'ID операції',
            'sheet_id' => 'ID відомості',
            'service_id' => 'ID послуги',
            'group_num' => 'Навчальна група',
            'time_start' => 'Початок надання послуги',
            'time_end' => 'Кінець надання посдуги',
            'input_cost' => 'Сума надходження, грн.',
            'tax_rate' => 'Ставка ПДВ, %',
            'customer_type' => 'Замовник',
            'hours' => 'Кількість навчальних годин',
            'student_count' => 'Чисельність групи, чол.',
            'addition_notes' => 'Уточнення послуги',
            'worker_fop' => 'ФОП виконавців, грн.',
            'university_spends' => 'Університетські витрати, %',
            'u_spends_value' => 'Університетські витрати, грн.',
            'communal_spends' => 'Комунальні витрати, %',
            'c_spends_value' => 'Комунальні витрати, грн.',
            'fop_spends' => 'ФОП університетських підрозділів, %',
            'f_spends_value' => 'ФОП університетських підрозділів, грн.',
            'fop_staffer' => 'ФОП штатних працівників, %',
            'fop_staffer_value' => 'ФОП штатних працівників, грн.',
            'material_costs' => 'Витратні матеріали, %',
            'material_costs_value' => 'Витратні матеріали, грн.',
            'capital_costs' => 'Капітальні витрати, %',
            'capital_costs_value' => 'Капітальні витрати, грн.',
            'univ_clinic_costs' => 'Витрати Університетської клініки, %',
            'univ_clinic_costs_value' => 'Витрати Університетської клініки, грн.',
            'direct_spends' => 'Прямі витрати, грн.',
            'version' => 'Версія відомості',
            'username' => 'Користувач',
            'operation_date' => 'Дата',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistributions()
    {
        return $this->hasMany(Distribution::className(), ['operation_id' => 'operation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::className(), ['service_id' => 'service_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSheet()
    {
        return $this->hasOne(Sheet::className(), ['sheet_id' => 'sheet_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpends()
    {
        return $this->hasMany(Spend::className(), ['operation_id' => 'operation_id']);
    }
}
