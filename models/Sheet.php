<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\db\Query;

/**
 * This is the model class for table "{{%Sheet}}".
 *
 * @property int $sheet_id
 * @property int $dept_id
 * @property string $sheet_time_start
 * @property string $sheet_time_end
 * @property string $sheet_notes
 * @property int $sheet_state
 * @property int $version
 * @property string $username
 * @property string $operation_date
 *
 * @property Registry[] $registries
 * @property Dept $dept
 */
class Sheet extends ActiveRecord
{
    const SERVICE_INFORMATION = 'report1';
    const SERVICE_DISTRIBUTION = 'report2';
    const DRAFT = 1;
    const PREPARED_FOR_BUHG = 2;
    const PREPARED_FOR_VMPP = 3;
    const VERIFIED = 4;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%Sheet}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dept_id', 'sheet_state', 'version'], 'integer'],
            [['sheet_time_start', 'sheet_time_end', 'username', 'operation_date'], 'required'],
            [['sheet_time_start', 'sheet_time_end', 'operation_date'], 'safe'],
            [['sheet_notes'], 'string', 'max' => 200],
            [['username'], 'string', 'max' => 50],
            [['dept_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dept::className(), 'targetAttribute' => ['dept_id' => 'dept_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sheet_id' => 'ID відомості',
            'dept_id' => 'ID підрозділу',
            'sheet_time_start' => 'Початок облікового періоду',
            'sheet_time_end' => 'Кінець облікового періоду',
            'sheet_notes' => 'Примітки',
            'sheet_state' => 'Статус відомості',
            'version' => 'Версія відомості',
            'username' => 'Користувач',
            'operation_date' => 'Дата',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegistries()
    {
        return $this->hasMany(Registry::className(), ['sheet_id' => 'sheet_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDept()
    {
        return $this->hasOne(Dept::className(), ['dept_id' => 'dept_id']);
    }

    public static function getDataSheet($sheet_id, $type)
    {
        $dataSheet = [];
        if ($type == self::SERVICE_INFORMATION) {
            $report = Sheet::getReport1($sheet_id);
            $output = Sheet::getAdaptedResponse($report, [
                'operation_id',
                ['spend_id', 'spend_type', 'spend_cost'],
                'service_dept_id',
                'service_dept_name'
            ],
                $type
            );
            $result = $output['result'];
            $dataSheet = ['result' => $result];
        }
        if ($type == self::SERVICE_DISTRIBUTION) {
            $report = Sheet::getReport2($sheet_id);
            $output = Sheet::getAdaptedResponse($report, [
                'operation_id',
                ['sub_cost', 'sub_cost_value', 'sub_fop', 'sub_fop_value', 'sub_other', 'sub_other_value'],
                'distribution_dept_id',
                'distribution_dept_name'
            ],
                $type
            );
            $result = $output['result'];
            $distribution_set = $output['distribution_set'];
            $dst_names_set = $output['dst_names_set'];
            $dept_columns = Sheet::getOutputDistribution($distribution_set, $dst_names_set);
            $output_distribution = $dept_columns['distribution'];
            $distribution_columns_count = $dept_columns['columns_count'];
            $distribution_names = $dept_columns['dst_names'];
            $column_sum = Sheet::getDistributionColumnsSum($result, $output_distribution);
            $dataSheet = [
                'result' => $result,
                'out_dist' => $output_distribution,
                'dist_col_count' => $distribution_columns_count,
                'dist_names' => $distribution_names,
                'column_sum' => $column_sum
            ];
        }
        return $dataSheet;
    }

    private static function getReport1($sheet_id)
    {
        $report1 = (new Query())
            ->select([
                Registry::tableName() . '.operation_id',
                'service_name',
                'addition_notes',
                'group_num',
                'time_start',
                'time_end',
                'input_cost',
                'customer_type',
                'hours',
                'student_count',
                'worker_fop',
                'direct_spends',
                'spend_id',
                'spend_type',
                'spend_cost',
                Service::tableName() . '.dept_id AS service_dept_id',
                Dept::tableName() . '.dept_name AS service_dept_name'
            ])
            ->from([Registry::tableName()])
            ->leftJoin([Service::tableName()], Registry::tableName() . '.service_id = ' . Service::tableName() . '.service_id')
            ->leftJoin([Dept::tableName()], Service::tableName() . '.dept_id = ' . Dept::tableName() . '.dept_id')
            ->leftJoin([Spend::tableName()], Registry::tableName() . '.operation_id = ' . Spend::tableName() . '.operation_id')
            ->where(Registry::tableName() . '.sheet_id = :sheet_id', [':sheet_id' => $sheet_id])
            ->orderBy(['operation_id' => SORT_ASC])
            ->all();
        return $report1;
    }

    private static function getReport2($sheet_id)
    {
        $report2 = (new Query())
            ->select([
                Registry::tableName() . '.operation_id',
                'service_name',
                'addition_notes',
                'group_num',
                'input_cost',
                'tax_rate',
                'university_spends',
                'u_spends_value',
                'communal_spends',
                'c_spends_value',
                'fop_spends',
                'f_spends_value',
                'direct_spends',
                'sub_cost',
                'sub_cost_value',
                'sub_fop',
                'sub_fop_value',
                'sub_other',
                'sub_other_value',
                Distribution::tableName() . '.dept_id AS distribution_dept_id',
                'dept_2.dept_name AS distribution_dept_name'
            ])
            ->from([Registry::tableName()])
            ->leftJoin([Service::tableName()], Registry::tableName() . '.service_id = ' . Service::tableName() . '.service_id')
            ->leftJoin([Dept::tableName() . ' dept_1'], Service::tableName() . '.dept_id = dept_1.dept_id')
            ->leftJoin([Distribution::tableName()], Registry::tableName() . '.operation_id = ' . Distribution::tableName() . '.operation_id')
            ->leftJoin([Dept::tableName() . ' dept_2'], Distribution::tableName() . '.dept_id = dept_2.dept_id')
            ->where(Registry::tableName() . '.sheet_id = :sheet_id', [':sheet_id' => $sheet_id])
            ->orderBy(['operation_id' => SORT_ASC, 'sub_cost' => SORT_DESC])
            ->all();
        return $report2;
    }

    private static function getAdoptedResponse($report, $params, $type)
    {
        $main_key = $params[0];
        $merge_keys = $params[1];
        $identifier_key = $params[2];
        $ik_name = $params[3];
        $groups = [];
        $result = [];
        $distribution_set = [];
        $distribution_names_set = [];
        $group_index = 0;
        $current_index = 0;
        for ($i = 0; $i < count($report); $i++) {
            if ($i == 0) {
                $groups[$group_index] = $current_index;
                foreach (array_keys($report[$i]) as $base_key) {
                    if (!in_array($base_key, $merge_keys)) {
                        $result[$group_index]["{$base_key}"] = $report[$i]["{$base_key}"];
                    } else {
                        $result[$group_index]["{$base_key}"] = [];
                        if ($type == self::SERVICE_INFORMATION) {
                            array_push($result[$group_index]["{$base_key}"], $report[$i]["{$base_key}"]);
                        } elseif ($type == self::SERVICE_DISTRIBUTION) {
                            $result[$group_index]["{$base_key}"][$i] = [$report[$i]["{$identifier_key}"] => $report[$i]["{$base_key}"]];
                            $distribution_set[$group_index][$report[$i]["{$identifier_key}"]][$current_index] = $i;
                        }
                    }
                }
            } else {
                if ($report[$i]["{$main_key}"] != $report[$i - 1]["{$main_key}"]) {
                    $current_index = 0;
                    $group_index++;
                    $groups[$group_index] = $current_index;
                    foreach (array_keys($report[$i]) as $base_key) {
                        if (!in_array($base_key, $merge_keys)) {
                            $result[$group_index]["{$base_key}"] = $report[$i]["{$base_key}"];
                        } else {
                            $result[$group_index]["{$base_key}"] = [];
                            if ($type == self::SERVICE_INFORMATION) {
                                array_push($result[$group_index]["{$base_key}"], $report[$i]["{$base_key}"]);
                            } elseif ($type == self::SERVICE_DISTRIBUTION) {
                                $result[$group_index]["{$base_key}"][$i] = [$report[$i]["{$identifier_key}"] => $report[$i]["{$base_key}"]];
                                $distribution_set[$group_index][$report[$i]["{$identifier_key}"]][$current_index] = $i;
                            }
                        }
                    }
                } else {
                    $current_index++;
                    $groups[$group_index] = $current_index;
                    foreach (array_keys($report[$i]) as $base_key) {
                        if (!in_array($base_key, $merge_keys)) {
                            $result[$group_index]["{$base_key}"] = $report[$i]["{$base_key}"];
                        } else {
                            if ($type == self::SERVICE_INFORMATION) {
                                array_push($result[$group_index]["{$base_key}"], $report[$i]["{$base_key}"]);
                            } elseif ($type == self::SERVICE_DISTRIBUTION) {
                                $result[$group_index]["{$base_key}"][$i] = [$report[$i]["{$identifier_key}"] => $report[$i]["{$base_key}"]];
                                $distribution_set[$group_index][$report[$i]["{$identifier_key}"]][$current_index] = $i;
                            }
                        }
                    }
                }
            }
            if ($type == self::SERVICE_DISTRIBUTION) {
                $distribution_names_set[$report[$i]["{$identifier_key}"]] = $report[$i]["{$ik_name}"];
            }
            unset($result[$group_index]["{$identifier_key}"]);
            unset($result[$group_index]["{$ik_name}"]);
        }
        $output = ['result' => $result, 'distribution_set' => $distribution_set, 'dst_names_set' => $distribution_names_set];
        return $output;
    }

    private static function getOutputDistribution($distribution_set, $distribution_names_set)
    {
        $temp = [];
        $output_matrix = [];
        $output_distribution = [];
        foreach ($distribution_set as $key => $value) {
            foreach ($value as $k => $v) {
                if (!is_array($temp[$k])) {
                    $temp[$k] = [];
                }
                array_push($temp[$k], $v);
                if (!isset($output_matrix[$k])) {
                    $output_matrix[$k] = count($v);
                } else {
                    if ($output_matrix[$k] < count($v)) {
                        $output_matrix[$k] = count($v);
                    }
                }
            }

        }
        foreach ($temp as $k => $v) {
            $t = [];
            foreach ($v as $dept_id => $val) {
                array_push($t, array_values($val));
            }
            $temp[$k] = $t;
        }
        $distribution_columns_count = 0;
        foreach ($output_matrix as $key => $value) {
            foreach ($temp as $k => $v) {
                if ($k == $key) {
                    $output_distribution[$k] = [];
                    for ($i = 0; $i < $value; $i++) {
                        $tmp = [];
                        foreach ($v as $idx => $val) {
                            if (isset($val[$i])) {
                                array_push($tmp, $val[$i]);
                            }
                        }
                        array_push($output_distribution[$k], $tmp);
                        if (!empty($k)) {
                            $distribution_columns_count++;
                        }
                    }
                }
            }
        }
        $tmp = [];
        foreach ($output_matrix as $dept_id => $count) {
            foreach ($distribution_names_set as $di => $dst_name) {
                if ($di == $dept_id) {
                    for ($i = 0; $i < $count; $i++) {
                        array_push($tmp, $dst_name);
                    }
                }
            }
        }
        $distribution_names = $tmp;
        $dept_columns = [
            'distribution' => $output_distribution,
            'columns_count' => $distribution_columns_count,
            'dst_names' => $distribution_names
        ];
        return $dept_columns;
    }

    private static function getDistributionColumnsSum($result, $output_distribution)
    {
        $sum_values = [];
        foreach ($output_distribution as $dept_id => $value) {
            if (!empty($dept_id)) {
                foreach ($value as $item => $val) {
                    $sum_sub_cost_value = 0;
                    $sum_sub_fop_value = 0;
                    $sum_sub_other_value = 0;
                    foreach ($val as $idx) {
                        for ($i = 0; $i < count($result); $i++) {
                            foreach ($result[$i]['sub_cost_value'] as $index => $v) {
                                if ($index == $idx) {
                                    foreach ($v as $di => $added_data) {
                                        if ($di == $dept_id) {
                                            $sum_sub_cost_value += $added_data;
                                        }
                                    }
                                }
                            }
                            foreach ($result[$i]['sub_fop_value'] as $index => $v) {
                                if ($index == $idx) {
                                    foreach ($v as $di => $added_data) {
                                        if ($di == $dept_id) {
                                            $sum_sub_fop_value += $added_data;
                                        }
                                    }
                                }
                            }
                            foreach ($result[$i]['sub_other_value'] as $index => $v) {
                                if ($index == $idx) {
                                    foreach ($v as $di => $added_data) {
                                        if ($di == $dept_id) {
                                            $sum_sub_other_value += $added_data;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    array_push($sum_values, $sum_sub_cost_value);
                    array_push($sum_values, $sum_sub_fop_value);
                    array_push($sum_values, $sum_sub_other_value);
                }
            }
        }
        return $sum_values;
    }

    public function getSheetStatesList()
    {
        return [
            ['id' => self::DRAFT, 'title' => 'Чорновик'],
            ['id' => self::PREPARED_FOR_BUHG, 'title' => 'Для бухгалтерії'],
            ['id' => self::PREPARED_FOR_VMPP, 'title' => 'Для відділу моніторингу'],
            ['id' => self::VERIFIED, 'title' => 'Затверджена'],
        ];
    }

    public function getSheetState($sheetState)
    {
        if ($sheetState == self::DRAFT) {
            return 'Чорновик';
        } elseif ($sheetState == self::PREPARED_FOR_BUHG) {
            return 'Для бухгалтерії';
        } elseif ($sheetState == self::PREPARED_FOR_VMPP) {
            return 'Для відділу моніторингу';
        } elseif ($sheetState == self::VERIFIED) {
            return 'Затверджена';
        } else {
            return 'Невідомий статус відомості';
        }
    }
}
