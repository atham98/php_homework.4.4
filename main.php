<?php
error_reporting(E_ALL);
require_once 'db_connect.php';

        if (!empty($_POST['structure'])) {
            $create_query = $_POST['structure'];
            $statement = $link->query($create_query);
        }

        if(isset($_GET['action'])) {
            if ($_GET['action'] === 'delete') {
                $delete = $_GET['table_index'];
                $statement = $link->query("DROP TABLE $delete");
                header('Location: main.php');
            }
        }

    $select = "SHOW TABLES";
    $statement = $link->query($select);
    ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Управление таблицы</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Управление таблицами с помощью PHP</h1>
    <form method="post" action="main.php">
        <div class="structure">
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
            <div>
                <input type="submit" name="submit" value="Создать">
            </div>
        </div>
    </form>
    <h2>Список таблиц в базе данных - &quot;<?= $db_name?>&quot;</h2>
    <div class="tables">
        <?php while($row = $statement->fetch(PDO::FETCH_ASSOC)): ?>
           <div class="edit <?= $row["Tables_in_$db_name"]; ?>">
            <dl>
                <dt class="tb_name"><?= $row["Tables_in_$db_name"]; ?></dt>
                    <dd><a href="table.php?table_index=<?= $row["Tables_in_$db_name"]; ?>&action=show_structure" class="button">Структура Таблицы</a></dd>
                    <dd><a href="main.php?table_index=<?= $row["Tables_in_$db_name"]; ?>&action=delete" class="button">Удалить Таблицы</a></dd>
            </dl>
           </div>
        <?php endwhile ?>
    </div>
</body>
</html>