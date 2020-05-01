<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Sheet;

/**
 * SheetSearch represents the model behind the search form of `app\models\Sheet`.
 */
class SheetSearch extends Sheet
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sheet_id', 'dept_id', 'sheet_state', 'version'], 'integer'],
            [['sheet_time_start', 'sheet_time_end', 'sheet_notes', 'username', 'operation_date'], 'safe'],
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
        $query = Sheet::find();

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
            'sheet_id' => $this->sheet_id,
            'dept_id' => $this->dept_id,
            'sheet_time_start' => $this->sheet_time_start,
            'sheet_time_end' => $this->sheet_time_end,
            'sheet_state' => $this->sheet_state,
            'version' => $this->version,
            'operation_date' => $this->operation_date,
        ]);

        $query->andFilterWhere(['like', 'sheet_notes', $this->sheet_notes])
            ->andFilterWhere(['like', 'username', $this->username]);

        return $dataProvider;
    }
}
