<?php
    include_once 'database_connection.php';
    
    $wadaMemberUserLoginID = $_SESSION['wadaMemberUserLoginID'];

    $mysqli = db_connect();

    $stmt = $mysqli->prepare("SELECT `usersLoginID`, `userEmail`, `userUsername` FROM `wadamemberlogindata` WHERE usersLoginID = ?");
    $stmt->bind_param('i', $wadaMemberUserLoginID);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($usersLoginID, $userEmail, $userUsername);
    $stmt->fetch();

    $stmt->close();
?>