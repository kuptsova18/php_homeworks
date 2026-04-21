<?php
session_start();

$_SESSION['count'] = (isset($_SESSION['count']) ? $_SESSION['count'] : 0);


$_SESSION['count']++;
if ($_SESSION['count'] % 3 === 0) {
    header('Location: result.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Counter</title>
</head>

<body>
    <h1>Страница счётчика</h1>
    <p>Текущее количество открытий: <strong><?php echo $_SESSION['count']; ?></strong></p>
</body>

</html>