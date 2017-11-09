<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'homework_4_4';

$link =  new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
