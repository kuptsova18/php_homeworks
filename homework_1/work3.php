<?php
// variant 1
$variable = 3.14;
if (is_bool($variable)) {
    $type = 'bool';
} elseif (is_int($variable)) {
    $type = 'int';
} elseif (is_float($variable)) {
    $type = 'float';
} elseif (is_string($variable)) {
    $type = 'string';
} elseif (is_null($variable)) {
    $type = 'null';
} else {
    $type = 'other';
}

echo "type is $type";

//variant 2
switch (true) {
    case is_bool($variable):
        $type = 'bool';
        break;
    case is_int($variable):
        $type = 'int';
        break;
    case is_float($variable):
        $type = 'float';
        break;
    case is_string($variable):
        $type = 'string';
        break;
    case is_null($variable):
        $type = 'null';
        break;
    default:
        $type = 'other';
}

echo "type is $type";