<?php
    require_once 'database_connection.php';

    $mysqli = db_connect();
    if($mysqli){
        $stmt = $mysqli->prepare("SELECT COUNT(wadaConnectApplicationListingID) FROM `wadaconnectapplicationlisting` WHERE wadaConnectApplicationStatus = 'Pending' AND wadaConnectApplicationWadaSentStatus = 'Sent' AND DATE(wadaConnectApplicationDateTime) = CURRENT_DATE();");
        $stmt->execute();
        $stmt->bind_result($totalApplicationsPending);
        $stmt->fetch();
        $stmt->close();

        $stmt = $mysqli->prepare("SELECT COUNT(wadaConnectApplicationListingID) FROM `wadaconnectapplicationlisting` WHERE wadaConnectApplicationStatus = 'Approved' AND wadaConnectApplicationWadaSentStatus = 'Sent' AND DATE(wadaConnectApplicationDateTime) = CURRENT_DATE();");    
        $stmt->execute();
        $stmt->bind_result($totalApplicationsApproved);
        $stmt->fetch();
        $stmt->close();

        $stmt = $mysqli->prepare("SELECT COUNT(wadaConnectApplicationListingID) FROM `wadaconnectapplicationlisting` WHERE wadaConnectApplicationStatus = 'Rejected' AND wadaConnectApplicationWadaSentStatus = 'Sent' AND DATE(wadaConnectApplicationDateTime) = CURRENT_DATE();");
        $stmt->execute();
        $stmt->bind_result($totalApplicationsRejected);
        $stmt->fetch();
        $stmt->close();

        $stmt = $mysqli->prepare("SELECT COUNT(wadaMemberID) FROM `wadamemberpersonaldetails`");
        $stmt->execute();
        $stmt->bind_result($totalWadaMembers);
        $stmt->fetch();
        $stmt->close();

        db_close($mysqli);
    }
    else{
        echo "Database connection error";
    }
?>