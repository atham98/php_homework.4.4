<?php
error_reporting(E_ALL);
require_once 'db_connect.php';

        if (!empty($_POST['structure'])) {
            $create_query = $_POST['structure'];
            $statement = $link->prepare($create_query);
            $statement->execute();
        }

        if(isset($_GET['action'])) {
            if ($_GET['action'] === 'delete') {
                $eee = $_GET['table_index'];
                $statement = $link->prepare("DROP TABLE $eee");
                $statement->execute();
                header('Location: index.php');
            }
        }
    $select = "SHOW TABLES";
    $statement = $link->query($select);
    ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Д.З. 4.4</title>
    <style>
        label{
            display: block;
        }
        form div{
            margin-bottom: 15px;
        }
        textarea{
            min-width: 500px;
            min-height: 250px;
        }
    </style>
</head>
<body>
    <h1>Управление таблицами с помощью PHP</h1>
    <form method="post" action="index.php">
        <div>
            <label>Структура таблицы:</label>
            <textarea name="structure" placeholder="Введите SQL запрос в формате:

            CREATE TABLE `table_name`(
            `id` int NOT NULL auto_increment,
            `title` varchar(255) NOT NULL,
            `description` varchar(255) NOT NULL,
            `content` text,
            `author` varchar(50) NOT NULL,
            `pubdate` timestamp NOT NULL,
            PRIMARY KEY(id)
            )
            "></textarea>
        </div>
        <div>
            <input type="submit" name="submit" value="Создать">
        </div>
    </form>
    <h2>Список таблиц в базе данных - &quot;<?= $db_name?>&quot;</h2>
    <ul>
        <?php while($row = $statement->fetch(PDO::FETCH_ASSOC)): ?>
            <li>
                <?= $row["Tables_in_$db_name"]; ?>
                <a href="table.php?table_index=<?= $row["Tables_in_$db_name"]; ?>&action=showstructure" class="button-structure">Структура таблицы</a>
                <a href="index.php?table_index=<?= $row["Tables_in_$db_name"]; ?>&action=delete" class="button-delete">Удалить таблицу</a>
            </li>
        <?php endwhile ?>
    </ul>
</body>
</html>