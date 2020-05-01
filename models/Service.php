<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%Service}}".
 *
 * @property int $service_id
 * @property int $parent_service_id
 * @property int $dept_id
 * @property string $pressmark
 * @property string $service_name
 *
 * @property Registry[] $registries
 * @property Dept $dept
 */
class Service extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%Service}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['service_id', 'service_name'], 'required'],
            [['service_id', 'parent_service_id', 'dept_id'], 'integer'],
            [['pressmark'], 'string', 'max' => 20],
            [['service_name'], 'string', 'max' => 100],
            [['service_id'], 'unique'],
            [['dept_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dept::className(), 'targetAttribute' => ['dept_id' => 'dept_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'service_id' => 'ID послуги',
            'parent_service_id' => 'ID старшої послуги',
            'dept_id' => 'ID підрозділу',
            'pressmark' => 'Шифр послуги',
            'service_name' => 'Назва послуги',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegistries()
    {
        return $this->hasMany(Registry::className(), ['service_id' => 'service_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDept()
    {
        return $this->hasOne(Dept::className(), ['dept_id' => 'dept_id']);
    }
}
