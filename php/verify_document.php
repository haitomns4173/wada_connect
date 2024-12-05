<?php
require_once 'database_connection.php';

$myqli = db_connect();

header('Content-Type: application/json'); // Return JSON response

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['wadaMemberDocumentCode'])) {
        $documentID = explode("-", $_POST['wadaMemberDocumentCode']);
        $wadaConnectApplicationListingID = $documentID[0];
        $wadaConnectApplicationID = $documentID[1];
        $wadaConnectApplicationUserID = $documentID[2];
        $wadaConnectApplicationType = $documentID[3];

        $stmt = $myqli->prepare("SELECT `wadaConnectApplicationApprovedDocument` FROM `wadaconnectapplicationlisting` WHERE wadaConnectApplicationListingID = ? AND wadaConnectApplicationID = ? AND wadaConnectApplicationUserID = ? AND wadaConnectApplicationType = ?;");
        $stmt->bind_param("iiii", $wadaConnectApplicationListingID, $wadaConnectApplicationID, $wadaConnectApplicationUserID, $wadaConnectApplicationType);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            echo json_encode(["status" => "invalid"]);
            exit();
        } else {
            $stmt->bind_result($wadaConnectApplicationApprovedDocument);
            $stmt->fetch();
            $stmt->close();

            $approvedDocumentLocation = "wadaMemberDocuments/applictionApproved/" . $wadaConnectApplicationApprovedDocument;
            echo json_encode(["status" => "valid", "documentUrl" => $approvedDocumentLocation]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Document Code is required."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid Request"]);
}
