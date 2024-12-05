<?php
require_once '../php/database_connection.php';

$mysqli = db_connect();

if ($mysqli) {
    if (isset($_GET['wadaConnectApplicationID']) && isset($_GET['wadaConnectApplicationUserID'])) {
        $stmt = "SELECT * FROM `wadaconnectapplicationlisting` INNER JOIN `wadaconnectapplicationtype` ON wadaConnectApplicationType = wadaConnectApplicationTypeID INNER JOIN `wadamemberpersonaldetails` ON `wadaMemberID` = `wadaConnectApplicationUserID` INNER JOIN `wadamemberaddressdetails` ON wadaMemberID = wadaMemberAddressDetailsID WHERE wadaConnectApplicationWadaSentStatus = 'Sent' AND wadaConnectApplicationListingID = ? AND wadaConnectApplicationUserID = ?;";
        $stmt = $mysqli->prepare($stmt);
        $stmt->bind_param("ii", $_GET['wadaConnectApplicationID'], $_GET['wadaConnectApplicationUserID']);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        foreach ($result as $row) {
            break;
        }
    } else {
        echo "Invalid Request";
    }
} else {
    echo "Database Connection Error";
}
