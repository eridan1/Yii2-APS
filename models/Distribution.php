<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%Distribution}}".
 *
 * @property int $distribution_id
 * @property int $operation_id
 * @property int $dept_id
 * @property string $sub_cost
 * @property string $sub_cost_value
 * @property string $sub_fop
 * @property string $sub_fop_value
 * @property string $sub_other
 * @property string $sub_other_value
 * @property int $version
 * @property string $username
 * @property string $operation_date
 *
 * @property Dept $dept
 * @property Registry $operation
 */
class Distribution extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%Distribution}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['operation_id', 'dept_id', 'version'], 'integer'],
            [['sub_cost', 'sub_fop', 'sub_other', 'username', 'operation_date'], 'required'],
            [['sub_cost', 'sub_cost_value', 'sub_fop', 'sub_fop_value', 'sub_other', 'sub_other_value'], 'number'],
            [['operation_date'], 'safe'],
            [['username'], 'string', 'max' => 50],
            [['dept_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dept::className(), 'targetAttribute' => ['dept_id' => 'dept_id']],
            [['operation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Registry::className(), 'targetAttribute' => ['operation_id' => 'operation_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'distribution_id' => 'ID розподілу',
            'operation_id' => 'ID операції',
            'dept_id' => 'ID цільового підрозділу',
            'sub_cost' => 'Кошти на субрахунку, % від залишку',
            'sub_cost_value' => 'Сума залишку, грн.',
            'sub_fop' => 'ФОП підрозділу, % від залишку',
            'sub_fop_value' => 'ФОП підрозділу, грн.',
            'sub_other' => 'Інші витрати, % від залишку',
            'sub_other_value' => 'Інші витрати, грн.',
            'version' => 'Версія відомості',
            'username' => 'Користувач',
            'operation_date' => 'Дата',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDept()
    {
        return $this->hasOne(Dept::className(), ['dept_id' => 'dept_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperation()
    {
        return $this->hasOne(Registry::className(), ['operation_id' => 'operation_id']);
    }
}
