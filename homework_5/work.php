<?php

function generateSchedule($year, $month) {
    // Получаем количество дней в месяце
    $dayMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    // Первое число - рабочий день
    $daysAfterWork = 0; // Сколько дней прошло после рабочего (0 = сегодня рабочий)
    $workDays = array();
    
    $day = 1;
    // Перебираем все дни месяца
    while ($day <= $dayMonth) {
        $dayOfWeek = date('N', mktime(0, 0, 0, $month, $day, $year));
       
        $isWorkDay = ($daysAfterWork == 0); // Проверяем, должен ли сегодня быть рабочий день по графику

        // Если сегодня рабочий день
        if($isWorkDay) {
            if($dayOfWeek == 6 || $dayOfWeek == 7){
                // Переносим на понедельник
                // Ищем ближайший понедельник
                $monday = $day;
                $mondayDayOfWeek = $dayOfWeek;

                while ($mondayDayOfWeek != 1 && $monday <= $dayMonth) {
                    $monday++;
                    $mondayDayOfWeek = date('N', mktime(0, 0, 0, $month, $monday, $year));
                }
                // Если понедельник в том же месяце
                if($monday <= $dayMonth) {
                    $workDays[$monday] = true;
                    $daysAfterWork = 1;
                    $day = $monday + 1;
                } else {
                    $workDays[$day] = true;
                    $daysAfterWork = 1;
                    $day++;
                }
            } else {
                $workDays[$day] = true; 
                // После рабочего дня - два выходных   
                $daysAfterWork = 1; 
                $day++;
            }
            //$daysAfterWork = 1;
        } else {
            // Выходной день
            $daysAfterWork++;
            if ($daysAfterWork > 2) {
                $daysAfterWork = 0; // После двух выходных - рабочий
            } 
            $day++;
        }
    }
    return $workDays;
}

$year = date('Y');
$month = date('m');

if($argc > 1) {
    $year = $argv[1];
}

if($argc > 2) {
    $month = $argv[2];
}

$workDays = generateSchedule($year, $month);

$monthNames = array(1 => 'Январь',
                    2 => 'Февраль',
                    3 => 'Март',
                    4 => 'Апрель',
                    5 => 'Май',
                    6 => 'Июнь',
                    7 => 'Июль',
                    8 => 'Август',
                    9 => 'Сентябрь',
                    10 => 'Октябрь',
                    11 => 'Ноябрь',
                    12 => 'Декабрь');

// Выводим название месяца
echo $monthNames[$month] . "\n\n";

$dayMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

for ($day = 1; $day <= $dayMonth; $day++) {
    if(isset($workDays[$day])) {
        echo "\033[32m" . $day . "+\033[0m" . "   "; 
    } else {
        echo $day . "    ";
    }

    $dayOfWeek = date('N', mktime(0, 0, 0, $month, $day, $year));
    if ($dayOfWeek == 7) {
        echo "\n";
    }
}

echo "\n";
?>