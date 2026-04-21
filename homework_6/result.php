<?php

session_start();

$count = $_SESSION['count'] ?? 0;
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Результат</title>
</head>

<body>
    <h1>Результат</h1>
    <p>Страница счётчика была открыта <strong><?php echo $count; ?></strong> раз(а).</p>
</body>

</html>