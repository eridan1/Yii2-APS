<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%Spend}}".
 *
 * @property int $spend_id
 * @property int $operation_id
 * @property string $spend_type
 * @property string $spend_cost
 * @property int $version
 * @property string $username
 * @property string $operation_date
 *
 * @property Registry $operation
 */
class Spend extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%Spend}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['operation_id', 'version'], 'integer'],
            [['spend_type', 'spend_cost', 'username', 'operation_date'], 'required'],
            [['spend_cost'], 'number'],
            [['operation_date'], 'safe'],
            [['spend_type'], 'string', 'max' => 100],
            [['username'], 'string', 'max' => 50],
            [['operation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Registry::className(), 'targetAttribute' => ['operation_id' => 'operation_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'spend_id' => 'ID прямих витрат',
            'operation_id' => 'ID операції',
            'spend_type' => 'Вид витрат',
            'spend_cost' => 'Сума витрат, грн.',
            'version' => 'Версія відомості',
            'username' => 'Користувач',
            'operation_date' => 'Дата',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperation()
    {
        return $this->hasOne(Registry::className(), ['operation_id' => 'operation_id']);
    }
}
