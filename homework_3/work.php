<?php
echo 'Введите имя: ';
$name = trim(fgets(STDIN));

echo 'Введите фамилию: ';
$surname = trim(fgets(STDIN));

echo 'Введите отчество: ';
$patronymic = trim(fgets(STDIN));

// Преобразование первой буквы в верхний регистр
$name = mb_convert_case($name, MB_CASE_TITLE, "UTF-8");
$surname = mb_convert_case($surname, MB_CASE_TITLE, "UTF-8");
$patronymic = mb_convert_case($patronymic, MB_CASE_TITLE, "UTF-8");

// Полное имя: Фамилия Имя Отчество
$fullName = "{$surname} {$name} {$patronymic}";

// Аббревиатура: первые буквы (с помощью mb_substr для кириллицы)
$fio = mb_substr($surname, 0, 1, "UTF-8") . 
       mb_substr($name, 0, 1, "UTF-8") . 
       mb_substr($patronymic, 0, 1, "UTF-8");

// Фамилия и инициалы
$surnameAndInitials = $surname . ' ' . 
                      mb_substr($name, 0, 1, "UTF-8") . '.' . 
                      mb_substr($patronymic, 0, 1, "UTF-8") . '.';

echo "Полное имя: '{$fullName}'\n";
echo "Фамилия и инициалы: '{$surnameAndInitials}'\n";
echo "Аббревиатура: '{$fio}'\n";
?>