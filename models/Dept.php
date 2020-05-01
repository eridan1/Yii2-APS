<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%Dept}}".
 *
 * @property int $dept_id
 * @property int $parent_dept_id
 * @property string $pressmark
 * @property string $dept_name
 * @property string $dept_abbreviate
 * @property int $is_sub_exists
 * @property int $sheet_type
 *
 * @property Distribution[] $distributions
 * @property Service[] $services
 * @property Sheet[] $sheets
 * @property User[] $users
 */
class Dept extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%Dept}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dept_id', 'dept_name', 'dept_abbreviate', 'is_sub_exists'], 'required'],
            [['dept_id', 'parent_dept_id', 'is_sub_exists', 'sheet_type'], 'integer'],
            [['pressmark', 'dept_abbreviate'], 'string', 'max' => 20],
            [['dept_name'], 'string', 'max' => 100],
            [['dept_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'dept_id' => 'ID підрозділу',
            'parent_dept_id' => 'ID старшого підрозділу',
            'pressmark' => 'Шифр підрозділу',
            'dept_name' => 'Назва підрозділу',
            'dept_abbreviate' => 'Абревіатура підрозділу',
            'is_sub_exists' => 'Наявність субрахунку',
            'sheet_type' => 'Тип відомості',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistributions()
    {
        return $this->hasMany(Distribution::className(), ['dept_id' => 'dept_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasMany(Service::className(), ['dept_id' => 'dept_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSheets()
    {
        return $this->hasMany(Sheet::className(), ['dept_id' => 'dept_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['dept_id' => 'dept_id']);
    }
}
