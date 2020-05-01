<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%Group}}".
 *
 * @property int $group_id
 * @property string $group_name
 * @property int $group_index
 *
 * @property UserGroup[] $userGroups
 */
class Group extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%Group}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group_name'], 'required'],
            [['group_index'], 'integer'],
            [['group_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'group_id' => 'ID ролі',
            'group_name' => 'Назва ролі',
            'group_index' => 'Індекс ролі',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserGroups()
    {
        return $this->hasMany(UserGroup::className(), ['group_id' => 'group_id']);
    }
}
