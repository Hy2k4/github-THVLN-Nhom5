<?php
$db_host = '127.0.0.1';
$db_username = 'root';
$db_password = '';
$db_name = 'thlvnn5';

function connect_db() {
    global $db_host, $db_username, $db_password, $db_name;

    $mysqli = new mysqli($db_host, $db_username, $db_password, $db_name);

    if ($mysqli->connect_error) {
        die("Kết nối thất bại: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
    }

    $mysqli->set_charset("utf8mb4");

    return $mysqli;
}
?>
