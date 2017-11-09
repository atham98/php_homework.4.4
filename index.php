<?php
    require_once 'db_connect.php';
    $structure = htmlspecialchars(trim($_POST['structure']));
    $table_name = $_GET['tablename'];

    if($link){
        $create_query = "$structure";
        $statement = $link->prepare($create_query);
        $statement->execute();
    }
    if($_GET['action'] == 'delete'){
        $query_delete = "DROP TABLE $table_name";
        $statement = $link->prepare($query_delete);
        $statement->execute();
        header('Location: index.php');
    }

    $select = "SHOW TABLES";
    $statement = $link->prepare($select);
    $statement->execute();
?><!doctype html>
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
                <?= $row['Tables_in_homework_4_4']; ?>
                <a href="table.php?tablename=<?= $row['Tables_in_homework_4_4']; ?>&action=showstructure" class="button-structure">Структура таблицы</a>
                <a href="index.php?tablename=<?= $row['Tables_in_homework_4_4']; ?>&action=delete" class="button-delete">Удалить таблицу</a>
            </li>
        <?php endwhile ?>
    </ul>
</body>
</html>