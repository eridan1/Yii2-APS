<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Dept;

/**
 * DeptSearch represents the model behind the search form of `app\models\Dept`.
 */
class DeptSearch extends Dept
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dept_id', 'parent_dept_id', 'is_sub_exists', 'sheet_type'], 'integer'],
            [['pressmark', 'dept_name', 'dept_abbreviate'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Dept::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'dept_id' => $this->dept_id,
            'parent_dept_id' => $this->parent_dept_id,
            'is_sub_exists' => $this->is_sub_exists,
            'sheet_type' => $this->sheet_type,
        ]);

        $query->andFilterWhere(['like', 'pressmark', $this->pressmark])
            ->andFilterWhere(['like', 'dept_name', $this->dept_name])
            ->andFilterWhere(['like', 'dept_abbreviate', $this->dept_abbreviate]);

        return $dataProvider;
    }
}
