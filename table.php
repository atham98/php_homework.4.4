<?php
error_reporting(E_ALL);

    require_once 'db_connect.php';
    if(!isset($_GET['table_index'])){
        header('Location:index.php');
    }
    if(!empty($_GET['table_index']) && $_GET['action'] == 'showstructure'){
        $eee = $_GET['table_index'];
        $statement = $link->prepare("DESCRIBE $eee");
        $statement->execute();
    }

    $result = [];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= isset($_GET['table_index'])?></title>
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

    <?php if(isset($_GET['table_index'])): ?>
        <?php while($row = $statement->fetch(PDO::FETCH_ASSOC)): ?>
            <?php $result[] = $row; ?>
        <?php endwhile;?>
        <table>
            <caption><?= $_GET['table_index']?></caption>
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
            <?php endforeach; ?>
        <?php endif; ?>
    </table>

</body>
</html>