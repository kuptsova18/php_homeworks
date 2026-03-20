<?php
$input = trim(fgets(STDIN));

// Проверяем, что ввод не пустой
if(empty($input)) {
    fwrite(STDERR, "Введите, пожалуйста, число\n");
    exit(1);
}
// Разделяем на части по пробелам
$parts = preg_split('/\s+/', $input);
if (count($parts) !== 2) {
    fwrite(STDERR, "Введите, пожалуйста, два целочисленных числа через пробел\n");
    exit(1);
}

$firstNum = $parts[0];
$secondNum = $parts[1];

// Проверяем, что оба значения - целые неотрицательные числа
if (!ctype_digit($firstNum) || !ctype_digit($secondNum)) {
    fwrite(STDERR, "Введите, пожалуйста, целочисленные неотрицательные числа\n");
    exit(1);
}

// Преобразуем в int для корректных вычислений
$firstNum = (int)$firstNum;
$secondNum = (int)$secondNum;

// Проверяем деление на ноль
if ($secondNum == 0) {
    fwrite(STDERR, "Делить на 0 нельзя\n");
    exit(1);
}

// Вычисляем и выводим результат
$result = $firstNum / $secondNum;
echo $result . "\n";
?>