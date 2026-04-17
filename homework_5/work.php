<?php

function generateSchedule($year, $month) {
    // Получаем количество дней в месяце
    $dayMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    // Первое число - рабочий день
    $isWorkDay = true;
    $workDays = array();
    $daysOff = 0; // Добавляем инициализацию
    
    // Перебираем все дни месяца
    for ($day = 1; $day <= $dayMonth; $day++) {
        $dayOfWeek = date('N', mktime(0, 0, 0, $month, $day, $year));
        
        // Если сегодня рабочий день
        if($isWorkDay) {
            if($dayOfWeek == 6 || $dayOfWeek == 7){
                // Переносим на понедельник
                // Ищем ближайший понедельник
                $monday = $day;
                $tempDayOfWeek = $dayOfWeek; // Используем временную переменную
                while ($tempDayOfWeek != 1){
                    $monday ++;
                    $tempDayOfWeek = date('N', mktime(0, 0, 0, $month, $monday, $year));
                }
                // Если понедельник в том же месяце
                if($monday <= $dayMonth) {
                    $workDays[$monday] = true;
                } else {
                    $workDays[$day] = true;
                }
            } else {
                $workDays[$day] = true; 
            }
            // После рабочего дня - два выходных (переносим за скобку условия)
            $isWorkDay = false;
            $daysOff = 2;
        } else {
            $daysOff--;
            if($daysOff == 0) {
                $isWorkDay = true;
            } 
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
        echo "\033[32m" . $day . "+\033[0m ". "   "; 
    } else {
        echo $day . "    ";
    }

    // Исправлено: используем текущий день, а не переменную $monday
    $dayOfWeek = date('N', mktime(0, 0, 0, $month, $day, $year));
    if ($dayOfWeek == 7) {
        echo "\n";
    }
}

echo "\n";
?>