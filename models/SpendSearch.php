<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Spend;

/**
 * SpendSearch represents the model behind the search form of `app\models\Spend`.
 */
class SpendSearch extends Spend
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['spend_id', 'operation_id', 'version'], 'integer'],
            [['spend_type', 'username', 'operation_date'], 'safe'],
            [['spend_cost'], 'number'],
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
        $query = Spend::find();

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
            'spend_id' => $this->spend_id,
            'operation_id' => $this->operation_id,
            'spend_cost' => $this->spend_cost,
            'version' => $this->version,
            'operation_date' => $this->operation_date,
        ]);

        $query->andFilterWhere(['like', 'spend_type', $this->spend_type])
            ->andFilterWhere(['like', 'username', $this->username]);

        return $dataProvider;
    }
}
