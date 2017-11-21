<?php
error_reporting(E_ALL);

// Если нет название таблицы то сделать ридирект на 'main.php'
if(!isset($_GET['table_index'])){
    header('Location:main.php');
    exit();
}
// Подключаем база данных
require_once 'db_connect.php';

// Выполнять если существует название таблицы
if(!empty($_GET['table_index'])) {
    $tb_name = $_GET['table_index'];
    $statement = $link->query("DESCRIBE $tb_name");
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    $fd_title = $_GET['title'] ?? false;                   // Присваиваем название поля
    $new_title = $_POST['fd_value'] ?? false;                   // Присваиваем то что написал пользователь
    $fd_type = $_GET['type'] ?? false;                      // Присваиваем тип поля

// Удалять поля
        if(isset($_GET['action_edit']) && $_GET['action_edit'] === 'delete'){
            $fd_delete = "ALTER TABLE $tb_name DROP COLUMN $fd_title";
            $link->query($fd_delete);
            header("Location:table.php?table_index=$tb_name");
        }
// Изменять название поля
    if (isset($_POST['submit']) && !empty($_POST['fd_value'])) {
        if($_GET['action_edit'] === 'change_title'){
            $update_title = "ALTER TABLE $tb_name CHANGE $fd_title $new_title $fd_type NOT NULL";
            $link->query($update_title);
            header("Location:table.php?table_index=$tb_name");
        }
// Изменять тип поля
        if($_GET['action_edit'] === 'change_type'){
            $update_type = "ALTER TABLE $tb_name MODIFY $fd_title $new_title";
            $link->query($update_type);
            header("Location:table.php?table_index=$tb_name");
        }
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Структура таблиц</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<a href="main.php" class="button">Назад</a>
    <?php if(isset($statement)): ?>
        <?php if(isset($_GET['action'])):

// Если 'action' равен на 'change_type' или 'change_title' Показывать форму

            if($_GET['action'] === 'change_type' || $_GET['action'] === 'change_title'): ?>
                <p>Поля - `<?= $fd_title; ?>`</p>
        <form action="table.php?table_index=<?= $tb_name ;?>&title=<?= $_GET['title']; ?>&type=<?= $_GET['type']; ?>&action_edit=<?= $_GET['action']; ?>" method="post">
            <input type="text" name="fd_value">
            <input type="submit" name="submit" value="Изменить">
        </form>
    <?php endif; endif; ?>
        <table>
            <caption class="tb_name"><?= $tb_name; ?></caption>
            <tr>
                <th>Поле</th>
                <th>Тип</th>
                <th>Null</th>
                <th>Индекс</th>
                <th>По умолчанию</th>
                <th>Изменить Название</th>
                <th>Изменить тип</th>
                <th>Удалить</th>
            </tr>
            <?php foreach($result as $row) : ?>
                <tr>
                    <td><?= $row['Field']?></td>
                    <td><?= $row['Type']?></td>
                    <td><?= $row['Null']?></td>
                    <td><?= $row['Key']?></td>
                    <td><?= $row['Default']?></td>

                    <td><a href="?table_index=<?= $tb_name; ?>&title=<?= $row['Field']; ?>&type=<?= $row['Type']; ?>&action=change_title">Изменить</a></td>
                    <td><a href="?table_index=<?= $tb_name; ?>&title=<?= $row['Field']; ?>&type=<?= $row['Type']; ?>&action=change_type">Изменить</a></td>
                    <td><a href="?table_index=<?= $tb_name; ?>&title=<?= $row['Field']; ?>&action_edit=delete">Удалить</a></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</body>
</html>