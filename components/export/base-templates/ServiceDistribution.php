<?php

echo "<table class='report2'>";
echo "<caption>" . "Розподіл коштів, що отримані за надання платних послуг підрозділом " . $sheet_dept_name . " за період з " .
$sheet_time_start . " по " . $sheet_time_end . "</caption>";

$merge_keys = ['sub_cost', 'sub_cost_value', 'sub_fop', 'sub_fop_value', 'sub_other', 'sub_other_value'];
$cnt = empty($distribution_columns_count) ? 1 : $distribution_columns_count;

echo "<thead>";
echo "<tr>";
echo "<td rowspan='6'>" . "Назва послуги" . "</td>";
echo "<td rowspan='6'>" . "Надійшло всього за видом послуги, грн." . "</td>";
echo "<td rowspan='6'>" . "ПДВ, %" . "</td>";
echo "<td rowspan='6'>" . "Сума коштів без ПДВ, грн." . "</td>";
$cols = 7 + 6 * $cnt;
echo "<td colspan='{$cols}'>" . "у тому числі" . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td colspan='2' rowspan='4'>" . "Загальноуніверситетські витрати" . "</td>";
echo "<td colspan='2' rowspan='4'>" . "Комунальні витрати" . "</td>";
echo "<td colspan='2' rowspan='4'>" . "ФОП загальноуніверситетських підрозділів" . "</td>";
echo "<td rowspan='5'>" . "Безпосередні витрати, які були здійснені для надання послуги, грн." . "</td>";
$cols = 6 * $cnt;
echo "<td colspan='{$cols}'>" . "у тому числі кошти, що зараховуються на субрахунки" . "</td>";
echo "</tr>";

echo "<tr>";
foreach ($distribution_names as $dept_name) {
    if (isset($dept_name)) {
        echo "<td colspan='6'>" . "субрахунок підрозділу " . $dept_name . "</td>";
    }
}
echo "</tr>";

echo "<tr>";
for ($i = 0; $i < $cnt; $i++) {
    echo "<td colspan='2' rowspan='2'>" . "всього" . "</td>";
    echo "<td colspan='4'>" . "у тому числі за статтями витрат" . "</td>";
}
echo "</tr>";

echo "<tr>";
for ($i = 0; $i < $cnt; $i++) {
    echo "<td colspan='2'>" . "ФОП" . "</td>";
    echo "<td colspan='2'>" . "інші" . "</td>";
}
echo "</tr>";

echo "<tr>";
for ($i = 0; $i < 3; $i++) {
    echo "<td>" . "% від 4" . "</td>";
    echo "<td>" . "грн." . "</td>";
}
for ($i = 0; $i < $cnt; $i++) {
    $j = 13 + 6 * $i;
    echo "<td>" . "%" . "</td>";
    echo "<td>" . "грн." . "</td>";
    echo "<td>" . "% від {$j}" . "</td>";
    echo "<td>" . "грн." . "</td>";
    echo "<td>" . "% від {$j}" . "</td>";
    echo "<td>" . "грн." . "</td>";
}
echo "</tr>";

echo "<tr>";
for ($i = 1; $i < 12 + 6 * $cnt; $i++) {
    echo "<td>" . $i . "</td>";
}
echo "</tr>";
echo "</thead>";

$sum_input_cost = 0;
$sum_input_cost_without_gst = 0;
$sum_u_spends_value = 0;
$sum_c_spends_value = 0;
$sum_f_spends_value = 0;
$sum_direct_spends = 0;

echo "<tbody>";

for ($index = 0; $index < count($result); $index++) {

    $input_cost_without_gst = $result[$index]['input_cost'] * (1 - 0.01 * $result[$index]['tax_rate']);
    $sum_input_cost += $result[$index]['input_cost'];
    $sum_input_cost_without_gst += $input_cost_without_gst;
    $sum_u_spends_value += $result[$index]['u_spends_value'];
    $sum_c_spends_value += $result[$index]['c_spends_value'];
    $sum_f_spends_value += $result[$index]['f_spends_value'];
    $sum_direct_spends += $result[$index]['direct_spends'];

    echo "<tr>";
    if (!empty($result[$index]['addition_notes'])) {
        if (!empty($result[$index]['group_num'])) {
            echo "<td>" . $result[$index]['service_name'] . " (" . $result[$index]['addition_notes']
                . ", група " . $result[$index]['group_num'] . ")" . "</td>";
        } else {
            echo "<td>" . $result[$index]['service_name'] . " (" . $result[$index]['addition_notes'] . ")" . "</td>";
        }
    } else {
        echo "<td>" . $result[$index]['service_name'] . "</td>";
    }
    echo "<td>" . $result[$index]['input_cost'] . "</td>";
    echo "<td>" . $result[$index]['tax_rate'] . "</td>";
    echo "<td>" . $input_cost_without_gst . "</td>";
    echo "<td>" . $result[$index]['university_spends'] . "</td>";
    echo "<td>" . $result[$index]['u_spends_value'] . "</td>";
    echo "<td>" . $result[$index]['communal_spends'] . "</td>";
    echo "<td>" . $result[$index]['c_spends_value'] . "</td>";
    echo "<td>" . $result[$index]['fop_spends'] . "</td>";
    echo "<td>" . $result[$index]['f_spends_value'] . "</td>";
    echo "<td>" . $result[$index]['direct_spends'] . "</td>";
    foreach ($output_distribution as $dept_id => $value) {
        if (!empty($dept_id)) {
            foreach ($value as $key => $val) {
                $find = 0;
                foreach ($val as $idx => $v) {
                    foreach ($merge_keys as $distribution_key) {
                        foreach ($result[$index]["{$distribution_key}"] as $distribution_index => $distribution_data) {
                            foreach ($distribution_data as $distribution_dept_id => $distribution_value) {
                                if ($distribution_index == $v) {
                                    if (isset($distribution_value)) {
                                        echo "<td>" . $distribution_value . "</td>";
                                    } else {
                                        echo "<td>" . 0 . "</td>";
                                    }
                                    $find++;
                                }
                            }
                        }
                    }
                }
                if ($find == 0) {
                    for ($i = 0; $i < count($merge_keys); $i++) {
                        echo "<td>" . '&ndash;' . "</td>";
                    }
                }
            }
        }
    }
    echo "</tr>";
}
echo "<tr>";
for ($i = 1; $i < 12; $i++) {
    if ($i == 1) {
        echo "<td>" . 'Всього' . "</td>";
    } elseif ($i == 2) {
        echo "<td>" . $sum_input_cost . "</td>";
    } elseif ($i == 4) {
        echo "<td>" . $sum_input_cost_without_gst . "</td>";
    } elseif ($i == 6) {
        echo "<td>" . $sum_u_spends_value . "</td>";
    } elseif ($i == 8) {
        echo "<td>" . $sum_c_spends_value . "</td>";
    } elseif ($i == 10) {
        echo "<td>" . $sum_f_spends_value . "</td>";
    } elseif ($i == 11) {
        echo "<td>" . $sum_direct_spends . "</td>";
    } else {
        echo "<td>" . '&ndash;' . "</td>";
    }
}
foreach ($sum_values as $sum) {
    echo "<td>" . '&ndash;' . "</td>";
    echo "<td>" . $sum . "</td>";
}
if (empty($distribution_columns_count)) {
    for ($i = 0; $i < 3; $i++) {
        echo "<td>" . '&ndash;' . "</td>";
        echo "<td>" . 0 . "</td>";
    }
}
echo "</tr>";
echo "</tbody>";
echo "</table>";
