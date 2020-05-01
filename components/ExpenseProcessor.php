<?php

namespace app\components;

use app\models\Registry;
use app\models\Spend;
use app\models\Distribution;
use yii\base\Component;
use yii\db\Query;

class ExpenseProcessor extends Component
{
    private $uSpendsValue;
    private $cSpendsValue;
    private $fSpendsValue;
    private $fStafferValue;
    private $mCostsValue;
    private $cCostsValue;
    private $uClinicCostsValue;
    private $directSpends;
    private $subCostValue;
    private $subFopValue;
    private $subOtherValue;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function init()
    {
        parent::init();
    }

    /**
     * @return mixed
     */
    public function getUSpendsValue()
    {
        return $this->uSpendsValue;
    }

    /**
     * @return mixed
     */
    public function getCSpendsValue()
    {
        return $this->cSpendsValue;
    }

    /**
     * @return mixed
     */
    public function getFSpendsValue()
    {
        return $this->fSpendsValue;
    }

    public function getFStafferValue()
    {
        return $this->fStafferValue;
    }

    public function getMCostsValue()
    {
        return $this->mCostsValue;
    }

    public function getCCostsValue()
    {
        return $this->cCostsValue;
    }

    public function getUClinicCostsValue()
    {
        return $this->uClinicCostsValue;
    }

    /**
     * @return mixed
     */
    public function getDirectSpends()
    {
        return $this->directSpends;
    }

    /**
     * @return mixed
     */
    public function getSubCostValue()
    {
        return $this->subCostValue;
    }

    /**
     * @return mixed
     */
    public function getSubFopValue()
    {
        return $this->subFopValue;
    }

    /**
     * @return mixed
     */
    public function getSubOtherValue()
    {
        return $this->subOtherValue;
    }

    public function setSpendScope($op_id)
    {
        $row = (new Query())->select(['input_cost', 'tax_rate', 'u_spends_value', 'c_spends_value', 'f_spends_value',
            'fop_staffer_value', 'material_costs_value', 'capital_costs_value', 'univ_clinic_costs_value',
            'worker_fop'])
            ->from(Registry::tableName())->where('operation_id = :operation_id', [':operation_id' => $op_id])->one();
        $input_cost = $row['input_cost'];
        $tax_rate = $row['tax_rate'];
        $u_spends = $row['u_spends_value'];
        $c_spends = $row['c_spends_value'];
        $f_spends = $row['f_spends_value'];

        $f_staffer_value = $row['fop_staffer_value'];
        $m_costs_value = $row['material_costs_value'];
        $c_costs_value = $row['capital_costs_value'];
        $u_c_costs_value = $row['univ_clinic_costs_value'];

        $worker_fop = $row['worker_fop'];
        $initial_input_cost = $this->getInputCostWithoutGst($input_cost, $tax_rate);
        $sum_spend_cost = $this->getSumSpendCost($op_id);
        $direct_spends = $this->getDirectSpendsValue($worker_fop, $sum_spend_cost);
        $sub_cost_value = [];
        $sub_fop_value = [];
        $sub_other_value = [];
        $rest_cost = $this->getRestCostValue($initial_input_cost, $u_spends, $c_spends, $f_spends, $direct_spends);
        $dist = (new Query())->select(['distribution_id', 'sub_cost', 'sub_fop', 'sub_other'])->from(Distribution::tableName())
            ->where('operation_id = :operation_id', [':operation_id' => $op_id])->all();
        for ($i = 0; $i < count($dist); $i++) {
            $scv = $sub_cost_value[$dist[$i]['distribution_id']] = $this->getSubAccountCostValue($rest_cost, $dist[$i]['sub_cost']);
            $sub_fop_value[$dist[$i]['distribution_id']] = $this->getSubAccountFopValue($scv, $dist[$i]['sub_fop']);
            $sub_other_value[$dist[$i]['distribution_id']] = $this->getSubAccountOtherValue($scv, $dist[$i]['sub_other']);
        }
        $this->directSpends = $direct_spends;
        $this->subCostValue = $sub_cost_value;
        $this->subFopValue = $sub_fop_value;
        $this->subOtherValue = $sub_other_value;
    }

    public function setRegistryScope($input_cost, $tax_rate, $university_spends, $communal_spends, $fop_spends, $worker_fop, $op_id = null)
    {
        $initial_input_cost = $this->getInputCostWithoutGst($input_cost, $tax_rate);
        $u_spends = $this->getUniversitySpendsValue($initial_input_cost, $university_spends);
        $c_spends = $this->getCommunalSpendsValue($initial_input_cost, $communal_spends);
        $f_spends = $this->getFopSpendsValue($initial_input_cost, $fop_spends);
        $sum_spend_cost = $this->getSumSpendCost($op_id);
        $direct_spends = $this->getDirectSpendsValue($worker_fop, $sum_spend_cost);
        if (isset($op_id)) {
            $sub_cost_value = [];
            $sub_fop_value = [];
            $sub_other_value = [];
            $rest_cost = $this->getRestCostValue($initial_input_cost, $u_spends, $c_spends, $f_spends, $direct_spends);
            $dist = (new Query())->select(['sub_cost', 'sub_fop', 'sub_other'])->from(Distribution::tableName())
                ->where('operation_id = :operation_id', [':operation_id' => $op_id])->all();
            for ($i = 0; $i < count($dist); $i++) {
                $scv = $sub_cost_value[$dist[$i]['distribution_id']] = $this->getSubAccountCostValue($rest_cost, $dist[$i]['sub_cost']);
                $sub_fop_value[$dist[$i]['distribution_id']] = $this->getSubAccountFopValue($scv, $dist[$i]['sub_fop']);
                $sub_other_value[$dist[$i]['distribution_id']] = $this->getSubAccountOtherValue($scv, $dist[$i]['sub_other']);
            }
            $this->subCostValue = $sub_cost_value;
            $this->subFopValue = $sub_fop_value;
            $this->subOtherValue = $sub_other_value;
        }
        $this->uSpendsValue = $u_spends;
        $this->cSpendsValue = $c_spends;
        $this->fSpendsValue = $f_spends;
        $this->directSpends = $direct_spends;
    }

    public function setDistributionScope($op_id, $sub_cost, $sub_fop, $sub_other)
    {
        $sub_cost_value = [];
        $sub_fop_value = [];
        $sub_other_value = [];
        $row = (new Query())->select(['input_cost', 'tax_rate', 'u_spends_value', 'c_spends_value', 'f_spends_value', 'direct_spends'])
            ->from(Registry::tableName())->where('operation_id = :operation_id', [':operation_id' => $op_id])->one();
        $input_cost = $row['input_cost'];
        $tax_rate = $row['tax_rate'];
        $u_spends = $row['u_spends_value'];
        $c_spends = $row['c_spends_value'];
        $f_spends = $row['f_spends_value'];
        $direct_spends = $row['direct_spends'];
        $initial_input_cost = $this->getInputCostWithoutGst($input_cost, $tax_rate);
        $rest_cost = $this->getRestCostValue($initial_input_cost, $u_spends, $c_spends, $f_spends, $direct_spends);
        $scv = $sub_cost_value[0] = $this->getSubAccountCostValue($rest_cost, $sub_cost);
        $sub_fop_value[0] = $this->getSubAccountFopValue($scv, $sub_fop);
        $sub_other_value[0] = $this->getSubAccountOtherValue($scv, $sub_other);
        $this->subCostValue = $sub_cost_value;
        $this->subFopValue = $sub_fop_value;
        $this->subOtherValue = $sub_other_value;
    }

    private function getInputCostWithoutGst($input_cost, $tax_rate)
    {
        $input_cost_without_gst = $input_cost * (1 - 0.01 * $tax_rate);
        return $input_cost_without_gst;
    }

    private function getUniversitySpendsValue($input_cost_without_gst, $university_spends)
    {
        $u_spends_value = $university_spends * $input_cost_without_gst;
        return $u_spends_value;
    }

    private function getCommunalSpendsValue($input_cost_without_gst, $communal_spends)
    {
        $c_spends_value = $communal_spends * $input_cost_without_gst;
        return $c_spends_value;
    }

    private function getFopSpendsValue($input_cost_without_gst, $fop_spends)
    {
        $f_spends_value = $fop_spends * $input_cost_without_gst;
        return $f_spends_value;
    }

    private function getFopStafferValue($input_cost_without_gst, $fop_staffer_value) {
        $f_staffer_value = $fop_staffer_value * $input_cost_without_gst;
        return $f_staffer_value;
    }

    private function getMaterialCostsValue($input_cost_without_gst, $material_costs_value) {
        $m_costs_value = $material_costs_value * $input_cost_without_gst;
        return $m_costs_value;
    }

    private function getCapitalCostsValue($input_cost_without_gst, $capital_costs_value) {
        $c_costs_value = $capital_costs_value * $input_cost_without_gst;
        return $c_costs_value;
    }

    private function getUnivClinicCostsValue($input_cost_without_gst, $univ_clinic_costs_value) {
        $u_c_costs_value = $univ_clinic_costs_value * $input_cost_without_gst;
        return $u_c_costs_value;
    }

    private function getSumSpendCost($op_id)
    {
        $query = (new Query())->from(Spend::tableName())->where('operation_id = :operation_id', [':operation_id' => $op_id]);
        $sum_spend_cost = $query->sum('spend_cost');
        return $sum_spend_cost;
    }

    private function getDirectSpendsValue($worker_fop, $sum_spend_cost)
    {
        $direct_spends = $worker_fop + $sum_spend_cost;
        return $direct_spends;
    }

    private function getRestCostValue($input_cost_without_gst, $u_spends_value, $c_spends_value, $f_spends_value, $direct_spends)
    {
        $rest_cost = $input_cost_without_gst - $u_spends_value - $c_spends_value - $f_spends_value - $direct_spends;
        return $rest_cost;
    }

    private function getSubAccountCostValue($rest_cost, $sub_cost)
    {
        $sub_cost_value = 0.01 * $sub_cost * $rest_cost;
        return $sub_cost_value;
    }

    private function getSubAccountFopValue($sub_cost_value, $sub_fop)
    {
        $sub_fop_value = 0.01 * $sub_fop * $sub_cost_value;
        return $sub_fop_value;
    }

    private function getSubAccountOtherValue($sub_cost_value, $sub_other)
    {
        $sub_other_value = 0.01 * $sub_other * $sub_cost_value;
        return $sub_other_value;
    }
}
