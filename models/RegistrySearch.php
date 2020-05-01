<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Registry;

/**
 * RegistrySearch represents the model behind the search form of `app\models\Registry`.
 */
class RegistrySearch extends Registry
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['operation_id', 'sheet_id', 'service_id', 'student_count', 'version'], 'integer'],
            [['group_num', 'time_start', 'time_end', 'customer_type', 'addition_notes', 'username', 'operation_date'], 'safe'],
            [['input_cost', 'tax_rate', 'hours', 'worker_fop', 'university_spends', 'u_spends_value', 'communal_spends', 'c_spends_value', 'fop_spends', 'f_spends_value', 'fop_staffer', 'fop_staffer_value', 'material_costs', 'material_costs_value', 'capital_costs', 'capital_costs_value', 'univ_clinic_costs', 'univ_clinic_costs_value', 'direct_spends'], 'number'],
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
        $query = Registry::find();

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
            'operation_id' => $this->operation_id,
            'sheet_id' => $this->sheet_id,
            'service_id' => $this->service_id,
            'time_start' => $this->time_start,
            'time_end' => $this->time_end,
            'input_cost' => $this->input_cost,
            'tax_rate' => $this->tax_rate,
            'hours' => $this->hours,
            'student_count' => $this->student_count,
            'worker_fop' => $this->worker_fop,
            'university_spends' => $this->university_spends,
            'u_spends_value' => $this->u_spends_value,
            'communal_spends' => $this->communal_spends,
            'c_spends_value' => $this->c_spends_value,
            'fop_spends' => $this->fop_spends,
            'f_spends_value' => $this->f_spends_value,
            'fop_staffer' => $this->fop_staffer,
            'fop_staffer_value' => $this->fop_staffer_value,
            'material_costs' => $this->material_costs,
            'material_costs_value' => $this->material_costs_value,
            'capital_costs' => $this->capital_costs,
            'capital_costs_value' => $this->capital_costs_value,
            'univ_clinic_costs' => $this->univ_clinic_costs,
            'univ_clinic_costs_value' => $this->univ_clinic_costs_value,
            'direct_spends' => $this->direct_spends,
            'version' => $this->version,
            'operation_date' => $this->operation_date,
        ]);

        $query->andFilterWhere(['like', 'group_num', $this->group_num])
            ->andFilterWhere(['like', 'customer_type', $this->customer_type])
            ->andFilterWhere(['like', 'addition_notes', $this->addition_notes])
            ->andFilterWhere(['like', 'username', $this->username]);

        return $dataProvider;
    }
}
