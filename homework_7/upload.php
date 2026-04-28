<?php
//если поле file_name пустое, то выполнить редирект обратно на форму, для этого используйте функцию header из предыдущего занятия;
if (empty($_POST["file_name"])) {
    header("Location: index.html");
    exit;
}

//если файл не был передан на сервер, то тоже редиректнуть обратно на форму;
if (!isset($_FILES["content"]) || $_FILES["content"]["error"] != 0) {
    header("Location: index.html");
    exit;
}

if(!is_dir('upload')){
    mkdir('upload');
}
//иначе сохранить файл на сервер в каталог upload, используя имя из поля file_name и отобразить полный путь к сохранённому файлу и размер файла.

$path_file = 'upload/' . $_POST['file_name'];

move_uploaded_file($_FILES['content']['tmp_name'], $path_file);

echo "Полный путь: " . realpath($path_file) . "<br>";
echo "Размер: " . $_FILES['content']['size'] . " байт";

?>