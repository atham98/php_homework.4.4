<?php
    require_once 'db_connect.php';
    $table_name = $_GET['tablename'];

    if(!empty($table_name) && $_GET['action'] == 'showstructure'){
        $query_show_structure = "DESCRIBE $table_name";
        $statement = $link->prepare($query_show_structure);
        $statement->execute();
    }
    $result = [];
?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $table_name?></title>
    <style>
        table{
            border-collapse: collapse;
        }
        tr, td, th{
            border: 1px solid black;
            padding: 7px;
        }
    </style>
</head>
<body>

    <?php while($row = $statement->fetch(PDO::FETCH_ASSOC)): ?>
        <?php
        $result[] = $row;
        ?>
    <?php endwhile ?>
    <table>
        <caption><?= $table_name?></caption>
        <tr>
            <th>Поле</th>
            <th>Тип</th>
            <th>Null</th>
            <th>Индекс</th>
            <th>По умолчанию</th>
        </tr>
        <?php foreach($result as $row) : ?>
            <tr>
                <td><?= $row['Field']?></td>
                <td><?= $row['Type']?></td>
                <td><?= $row['Null']?></td>
                <td><?= $row['Key']?></td>
                <td><?= $row['Default']?></td>
            </tr>
        <?php endforeach ?>
    </table>

</body>
</html>