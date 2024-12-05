<?php
require_once '../php/database_connection.php';
require_once '../php/pdfCoder.php';

$mysqli = db_connect();

if ($mysqli) {
    if (isset($_GET['wadaConnectApplicationListingID'])) {

        $wadaConnectApplicationListingID = $_GET['wadaConnectApplicationListingID'];

        if (isset($_POST['applicationStatusUpdate'])) {
            $wadaApplicationStatus = $_POST['applicationStatusUpdate'];

            if ($wadaApplicationStatus == "Rejected") {
                if (isset($_POST['applicationRemarks'])) {
                    $wadaApplicationRemarks = $_POST['applicationRemarks'];
                } else {
                    echo "Please fill the remarks";
                    exit();
                }
            } else if ($wadaApplicationStatus == "Approved") {
                
                if ($_FILES['applicationDocuments']['error'] == 4) {
                    echo "Please upload the document";
                    exit();
                } else {
                    if ($_FILES['applicationDocuments']['size'] > 5 * 1024 * 1024) {
                        echo "File size exceeds 5MB limit.";
                        exit();
                    }

                    $fileType = mime_content_type($_FILES['applicationDocuments']['tmp_name']);
                    if ($fileType !== 'application/pdf') {
                        echo "Only PDF files are allowed.";
                        exit();
                    }

                    $randomChars = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'), 0, 5);
                    $randomNums = substr(str_shuffle('0123456789'), 0, 5);
                    $newFileName = $randomChars . $randomNums . '.pdf';

                    $uploadDir = '../wadaMemberDocuments/applictionApproved/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }

                    $filePath = $uploadDir . $newFileName;

                    if (move_uploaded_file($_FILES['applicationDocuments']['tmp_name'], $filePath)) {
                        echo "File uploaded successfully.";
                        $wadaApplicationDocuments = $newFileName;

                        $stmt = $mysqli->prepare("SELECT `wadaConnectApplicationListingID`, `wadaConnectApplicationID`, `wadaConnectApplicationUserID`, `wadaConnectApplicationType` FROM `wadaconnectapplicationlisting` WHERE wadaConnectApplicationListingID = ?;");
                        $stmt->bind_param("i", $wadaConnectApplicationListingID);
                        $stmt->execute();
                        $stmt->store_result();
                        $stmt->bind_result($wadaConnectApplicationListingID, $wadaConnectApplicationID, $wadaConnectApplicationUserID, $wadaConnectApplicationType);
                        $stmt->fetch();
                        $stmt->close();

                        $textToAdd = "Document ID: " . $wadaConnectApplicationListingID . "-" . $wadaConnectApplicationID . "-" . $wadaConnectApplicationUserID . "-" . $wadaConnectApplicationType;
                        addTextToTopOfPdf($filePath, $filePath, $textToAdd);
                    } else {
                        echo "Failed to upload the file.";
                        exit();
                    }
                }
            }
        } else {
            echo "Please fill all the fields";
            exit();
        }

        $stmt = $mysqli->prepare("UPDATE `wadaconnectapplicationlisting` SET `wadaConnectApplicationStatus`= ?,`wadaConnectApplicationApprovedDocument`= ?,`wadaConnectApplicationRemarks`= ? WHERE wadaConnectApplicationListingID = ?;");
        $stmt->bind_param("sssi", $wadaApplicationStatus, $wadaApplicationDocuments, $wadaApplicationRemarks, $wadaConnectApplicationListingID);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Application Status Updated Successfully";
        } else {
            echo "Failed to Update Application Status";
        }

        $stmt->close();
    } else {
        echo "Invalid Request";
    }
} else {
    echo "Database Connection Error";
}

db_close($mysqli);
