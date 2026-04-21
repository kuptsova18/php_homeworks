<?php

$text = $_GET['text'] ?? 'No text';

header('Content-Type: text/html charset=utf-8');
header('Content-Disposition: attachment; filename = "file.txt"');
header('Content-length: ' . strlen($text));

echo $text;
exit();