<?php
    require_once 'database_connection.php';

    session_start();
    session_destroy();
    
    if (isset($mysqli)) {
        db_close($mysqli);
    }

    header("Location: ../login.php");

    exit;
?>