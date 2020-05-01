<?php

echo "<table class='report1'>";
echo "<caption>" . "Інформація про надані платні послуги підрозділом " . $sheet_dept_name . " за період з " .
$sheet_time_start . " по " . $sheet_time_end . "</caption>";

echo "<thead>";
echo "<tr>";
echo "<td rowspan='3'>" . "Назва послуги" . "</td>";
echo "<td rowspan='3'>" . "Період надання послуги" . "</td>";
echo "<td rowspan='3'>" . "Обсяг коштів, що надійшли" . "</td>";
echo "<td rowspan='3'>" . "Джерело фінансування" . "</td>";
echo "<td rowspan='3'>" . "Обсяг виконаних робіт для надання послуги" . "</td>";
echo "<td colspan='4'>" . "Безпосередні витрати, які були здійснені для надання послуги" . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td rowspan='2'>" . "ФОП виконавців, грн." . "</td>";
echo "<td colspan='2'>" . "Інші види витрат" . "</td>";
echo "<td rowspan='2'>" . "Всього витрат (ст. 6 + 8), грн." . "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>" . "Вид витрат" . "</td>";
echo "<td>" . "Вартість, грн." . "</td>";
echo "</tr>";

echo "<tr>";
for ($i = 1; $i < 10; $i++) {
    echo "<td>" . $i . "</td>";
}
echo "</tr>";
echo "</thead>";

$sum_input_cost = 0;
$sum_worker_fop = 0;
$sum_spend_cost = 0;
$sum_direct_spends = 0;

echo "<tbody>";

for ($index = 0; $index < count($result); $index++) {

    $cnt = count($result[$index]['spend_id']);
    $sum_input_cost += $result[$index]['input_cost'];
    $sum_worker_fop += $result[$index]['worker_fop'];
    $sum_direct_spends += $result[$index]['direct_spends'];

    for ($i = 0; $i < $cnt; $i++) {
        $sum_spend_cost += $result[$index]['spend_cost'][$i];
        if ($i == 0) {
            echo "<tr>";
            if (!empty($result[$index]['addition_notes'])) {
                if (!empty($result[$index]['group_num'])) {
                    echo "<td rowspan='{$cnt}'>" . $result[$index]['service_name'] . " (" . $result[$index]['addition_notes']
                        . ", група " . $result[$index]['group_num'] . ")" . "</td>";
                } else {
                    echo "<td rowspan='{$cnt}'>" . $result[$index]['service_name'] . " (" . $result[$index]['addition_notes'] . ")" . "</td>";
                }
            } else {
                echo "<td rowspan='{$cnt}'>" . $result[$index]['service_name'] . "</td>";
            }
            echo "<td rowspan='{$cnt}'>" . $result[$index]['time_start'] . " &ndash; " . $result[$index]['time_end'] . "</td>";
            echo "<td rowspan='{$cnt}'>" . $result[$index]['input_cost'] . "</td>";
            echo "<td rowspan='{$cnt}'>" . $result[$index]['customer_type'] . "</td>";
            if (!empty((int)$result[$index]['hours'])) {
                if (!empty((int)$result[$index]['student_count'])) {
                    echo "<td rowspan='{$cnt}'>" . $result[$index]['hours'] . " год., " . $result[$index]['student_count'] . " чол." . "</td>";
                } else {
                    echo "<td rowspan='{$cnt}'>" . $result[$index]['hours'] . " год." . "</td>";
                }
            } else {
                if (!empty((int)$result[$index]['student_count'])) {
                    echo "<td rowspan='{$cnt}'>" . $result[$index]['student_count'] . " чол." . "</td>";
                } else {
                    echo "<td rowspan='{$cnt}'>" . '&ndash;' . "</td>";
                }
            }
            echo "<td rowspan='{$cnt}'>" . $result[$index]['worker_fop'] . "</td>";
            if (isset($result[$index]['spend_type'][0])) {
                echo "<td>" . $result[$index]['spend_type'][0] . "</td>";
            } else {
                echo "<td>" . '&ndash;' . "</td>";
            }
            if (isset($result[$index]['spend_cost'][0])) {
                echo "<td>" . $result[$index]['spend_cost'][0] . "</td>";
            } else {
                echo "<td>" . 0 . "</td>";
            }
            echo "<td rowspan='{$cnt}'>" . $result[$index]['direct_spends'] . "</td>";
            echo "</tr>";
        } else {
            echo "<tr>";
            if (isset($result[$index]['spend_type'][$i])) {
                echo "<td>" . $result[$index]['spend_type'][$i] . "</td>";
            } else {
                echo "<td>" . '&ndash;' . "</td>";
            }
            if (isset($result[$index]['spend_cost'][$i])) {
                echo "<td>" . $result[$index]['spend_cost'][$i] . "</td>";
            } else {
                echo "<td>" . 0 . "</td>";
            }
            echo "</tr>";
        }
    }
}
echo "<tr>";
for ($i = 1; $i < 10; $i++) {
    if ($i == 1) {
        echo "<td>" . 'Всього' . "</td>";
    } elseif ($i == 3) {
        echo "<td>" . $sum_input_cost . "</td>";
    } elseif ($i == 6) {
        echo "<td>" . $sum_worker_fop . "</td>";
    } elseif ($i == 8) {
        echo "<td>" . $sum_spend_cost . "</td>";
    } elseif ($i == 9) {
        echo "<td>" . $sum_direct_spends . "</td>";
    } else {
        echo "<td>" . '&ndash;' . "</td>";
    }
}
echo "</tr>";
echo "</tbody>";
echo "</table>";
