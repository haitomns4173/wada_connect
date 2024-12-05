<?php
    require_once 'database_connection.php';

    $mysqli = db_connect();

    if($_SESSION['wadaMemberID'] == 0){
        $wadaConnectApplicationListingID = 0;
    }
    else{
        $stmt = $mysqli->prepare("SELECT COUNT(wadaConnectApplicationListingID) FROM `wadaconnectapplicationlisting` WHERE wadaConnectApplicationUserID = ?;");
        $stmt->bind_param('i', $_SESSION['wadaMemberID']);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($wadaConnectApplicationListingID);
        $stmt->fetch();
    
        $stmt->close();
    }
    
    db_close($mysqli);
?>