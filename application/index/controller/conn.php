<?php
require_once "database.php";

/**
 * 连接数据库
 */
$link = mysqli_connect(
    $database['host'],
    $database['usr'],
    $database['pwd'],
    $database['db']
);

if (!$link) {
    echo mysqli_connect_error();
    die;
}

