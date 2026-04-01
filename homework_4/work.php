<?php

declare(strict_types = 1);

const OPERATION_EXIT = 0;
const OPERATION_ADD = 1;
const OPERATION_DELETE = 2;
const OPERATION_PRINT = 3;
const OPERATION_EDIT = 4;
const OPERATION_UPDATE_QUANTITY = 5;

$operations = [
    OPERATION_EXIT => OPERATION_EXIT . '. Завершить программу.',
    OPERATION_ADD => OPERATION_ADD . '. Добавить товар в список покупок.',
    OPERATION_DELETE => OPERATION_DELETE . '. Удалить товар из списка покупок.',
    OPERATION_PRINT => OPERATION_PRINT . '. Отобразить список покупок.',
    OPERATION_EDIT => OPERATION_EDIT . '. Изменить название товара.',
    OPERATION_UPDATE_QUANTITY => OPERATION_UPDATE_QUANTITY . '. Изменить количество товара.',
];

$items = [];

function clearScreen(): void {
   system('clear'); 
}

function showMenuAndGetOperation(array $items, array $operations): int {
    do {
        if (count($items)) {
            echo 'Ваш список покупок: ' . PHP_EOL;
            echo implode("\n", $items) . "\n";
        } else {
            echo 'Ваш список покупок пуст.' . PHP_EOL;
        }

        echo 'Выберите операцию для выполнения: ' . PHP_EOL;

        $operationsToShow = $operations;
        if (count($items) === 0) {
            unset($operationsToShow[OPERATION_DELETE]);
            unset($operationsToShow[OPERATION_EDIT]);
            unset($operationsToShow[OPERATION_UPDATE_QUANTITY]);
        }

        echo implode(PHP_EOL, $operationsToShow) . PHP_EOL . '> ';
        $operationNumber = trim(fgets(STDIN));

        if (!array_key_exists($operationNumber, $operationsToShow)) {
            clearScreen();

            echo '!!! Неизвестный номер операции, повторите попытку.' . PHP_EOL;
        }

    } while (!array_key_exists($operationNumber, $operationsToShow));

    return (int)$operationNumber;
}

function addItemAction(array &$items): void
{
    echo "Введение название товара для добавления в список: \n> ";
    $itemName = trim(fgets(STDIN));

    if ($itemName === '') {
        echo 'Название товара не может быть пустым.' . PHP_EOL;
        echo 'Нажмите enter для продолжения';
        fgets(STDIN);
        return;
    }
    echo "Введите количество товара: \n> ";
    $quantity = trim(fgets(STDIN));
    if (!is_numeric($quantity) || (int)$quantity <=0) {
        $quantity = 1;
        echo "Количество не распознано, установлено значение по умолчанию: 1\n";
    }else {
        $quantity = (int)$quantity;
    }

    $items[] = [
        'name' => $itemName,
        'quantity' => $quantity
    ];

    echo "Товар \"$itemName\" в количестве $quantity добавлен в список." . PHP_EOL;
    echo 'Нажмите enter для продолжения';
    fgets(STDIN);
}

function deleteItemAction(array &$items): void
{
    printShoppingList($items);
    
    echo 'Введите номер товара для удаления:' . PHP_EOL . '> ';
    $itemNumber = trim(fgets(STDIN));
    
    if (!is_numeric($itemNumber) || $itemNumber < 1 || $itemNumber > count($items)) {
        echo 'Некорректный номер товара.' . PHP_EOL;
        echo 'Нажмите enter для продолжения';
        fgets(STDIN);
        return;
    }
    
    $itemIndex = (int)$itemNumber - 1;
    $deletedItem = $items[$itemIndex]['name'];
    unset($items[$itemIndex]);
    $items = array_values($items);
    
    echo "Товар \"$deletedItem\" удален из списка." . PHP_EOL;
    echo 'Нажмите enter для продолжения';
    fgets(STDIN);
}

function printShoppingList(array $items): void
{
    if (count($items) === 0) {
        echo 'Ваш список покупок пуст.' . PHP_EOL;
        return;
    }
    
    echo 'Ваш список покупок: ' . PHP_EOL;
    foreach ($items as $index => $item) {
        if (is_array($item)) {
            $quantity = $item['quantity'] ?? 1;
            echo ($index + 1) . '. ' . $item['name'] . ' (Количество: ' . $quantity . ')' . PHP_EOL;
        } else {
            echo ($index + 1) . '. ' . $item . PHP_EOL;
        }
    }
}

function printItemsAction(array $items): void
{
    printShoppingList($items);
    
    if (count($items) > 0) {
        $totalItems = count($items);
        $totalQuantity = array_sum(array_column($items, 'quantity'));
        echo 'Всего позиций: ' . $totalItems . '. ' . PHP_EOL;
        echo 'Общее количество товаров: ' . $totalQuantity . '. ' . PHP_EOL;
    }
    
    echo 'Нажмите enter для продолжения';
    fgets(STDIN);
}

function editItemNameAction(array &$items): void {
    printShoppingList($items);

    echo 'Введите номер товара для изменения названия: ' . PHP_EOL;
    $itemNumber = trim(fgets(STDIN));
    
    if (!is_numeric($itemNumber) || $itemNumber < 1 || $itemNumber > count($items)) {
        echo 'Некорректный номер товара.' . PHP_EOL;
        echo 'Нажмите enter для продолжения';
        fgets(STDIN);
        return;
    }
    $itemIndex = (int)$itemNumber - 1;
    $oldName = $items[$itemIndex]['name'];
    echo "Текущее название: $oldName" . PHP_EOL;
    echo 'Введите новое название товара:' . PHP_EOL . '> ';
    $newName = trim(fgets(STDIN));

    if ($newName === '') {
        echo 'Название товара не может быть пустым.' . PHP_EOL;
        echo 'Нажмите enter для продолжения';
        fgets(STDIN);
        return;
    }
     $items[$itemIndex]['name'] = $newName;
    echo "Название товара изменено с \"$oldName\" на \"$newName\"." . PHP_EOL;
    echo 'Нажмите enter для продолжения';
    fgets(STDIN);
}

function updateItemQuantityAction(array &$items): void
{
    printShoppingList($items);
    
    echo 'Введите номер товара для изменения количества:' . PHP_EOL . '> ';
    $itemNumber = trim(fgets(STDIN));
    
    if (!is_numeric($itemNumber) || $itemNumber < 1 || $itemNumber > count($items)) {
        echo 'Некорректный номер товара.' . PHP_EOL;
        echo 'Нажмите enter для продолжения';
        fgets(STDIN);
        return;
    }
    
    $itemIndex = (int)$itemNumber - 1;
    $itemName = $items[$itemIndex]['name'];
    $currentQuantity = $items[$itemIndex]['quantity'];
    
    echo "Товар: $itemName" . PHP_EOL;
    echo "Текущее количество: $currentQuantity" . PHP_EOL;
    echo 'Введите новое количество товара:' . PHP_EOL . '> ';
    $newQuantity = trim(fgets(STDIN));
    
    if (!is_numeric($newQuantity) || (int)$newQuantity <= 0) {
        echo 'Количество должно быть положительным числом. Изменение отменено.' . PHP_EOL;
        echo 'Нажмите enter для продолжения';
        fgets(STDIN);
        return;
    }
    
    $items[$itemIndex]['quantity'] = (int)$newQuantity;
    echo "Количество товара \"$itemName\" изменено с $currentQuantity на {$items[$itemIndex]['quantity']}." . PHP_EOL;
    echo 'Нажмите enter для продолжения';
    fgets(STDIN);
} 


do {
    clearScreen();
    $operationNumber = showMenuAndGetOperation(array $items, array $operations);

    echo 'Выбрана операция: '  . $operations[$operationNumber] . PHP_EOL;

    switch ($operationNumber) {
        case OPERATION_ADD:
            addItemAction($items);
            break;
        case OPERATION_DELETE:
            deleteItemAction($items);
            break;

        case OPERATION_PRINT:
            printItemsAction($items);
            break;

        case OPERATION_EDIT:
            editItemNameAction($items);
            break;
            
        case OPERATION_UPDATE_QUANTITY:
            updateItemQuantityAction($items);
            break;
    }

    echo "\n ----- \n";
} while ($operationNumber > 0);

echo 'Программа завершена' . PHP_EOL;