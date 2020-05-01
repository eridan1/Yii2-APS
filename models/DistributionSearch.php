<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Distribution;

/**
 * DistributionSearch represents the model behind the search form of `app\models\Distribution`.
 */
class DistributionSearch extends Distribution
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['distribution_id', 'operation_id', 'dept_id', 'version'], 'integer'],
            [['sub_cost', 'sub_cost_value', 'sub_fop', 'sub_fop_value', 'sub_other', 'sub_other_value'], 'number'],
            [['username', 'operation_date'], 'safe'],
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
        $query = Distribution::find();

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
            'distribution_id' => $this->distribution_id,
            'operation_id' => $this->operation_id,
            'dept_id' => $this->dept_id,
            'sub_cost' => $this->sub_cost,
            'sub_cost_value' => $this->sub_cost_value,
            'sub_fop' => $this->sub_fop,
            'sub_fop_value' => $this->sub_fop_value,
            'sub_other' => $this->sub_other,
            'sub_other_value' => $this->sub_other_value,
            'version' => $this->version,
            'operation_date' => $this->operation_date,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username]);

        return $dataProvider;
    }
}
