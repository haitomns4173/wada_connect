<?php
function db_connect() {
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPass = "";
    $dbName = "wadaconnect";

    $mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    if ($mysqli->connect_error) {
        die("Database Connection Failed : " . $mysqli->connect_error);
    }
    return $mysqli;
}

function db_close($mysqli) {
    $mysqli->close();
}
?>