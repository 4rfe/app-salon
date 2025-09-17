<?php
 

$db = mysqli_connect(
    $_ENV["MYSQL_HOST"],
    $_ENV["MYSQL_USER"],
    $_ENV["MYSQL_PASSWORD"],
    $_ENV["MYSQL_DATABASE"],
    $_ENV["MYSQL_PORT"]
);

$db->set_charset("utf8");

if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}
