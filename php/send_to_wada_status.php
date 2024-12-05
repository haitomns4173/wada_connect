<?php
require_once 'database_connection.php';

session_start();
$mysqli = db_connect();

if ($mysqli) {
    if (isset($_GET['wadaApplicationID']) && isset($_GET['wadaMemberFormID']) && isset($_GET['applicationType'])) {
        $wadaApplicationID = $_GET['wadaApplicationID'];
        $wadaMemberFormID = $_GET['wadaMemberFormID'];
        $applicationType = $_GET['applicationType'];

        $stmt = $mysqli->prepare("SELECT wadaConnectApplicationWadaSentStatus FROM wadaconnectapplicationlisting WHERE wadaConnectApplicationListingID = ? AND wadaConnectApplicationUserID = ?;");
        $stmt->bind_param('ii', $wadaApplicationID, $_SESSION['wadaMemberID']);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($wadaConnectApplicationWadaSentStatus);
        $stmt->fetch();

        if ($wadaConnectApplicationWadaSentStatus == 'Sent') {
            $_SESSION['status'] = 'success';
            $_SESSION['message'] = 'Application already sent to Wada Office.';
            if ($applicationType == 1) {
                header('Location: ../wadaUsers/wadaUsersApplication/four_boundaries_certificate_view.php?wadaMemberFourBoundariesFormID=' . $wadaMemberFormID . '');
            } else if ($applicationType == 2) {
                header('Location: ../wadaUsers/wadaUsersApplication/electricity_connection_recommendation_view.php?wadaMemberElectricityFormID=' . $wadaMemberFormID . '');
            } else if ($applicationType == 3) {
                header('Location: ../wadaUsers/wadaUsersApplication/relation_certificate_verification_view.php?wadaMemberRelationFormID=' . $wadaMemberFormID . '');
            } else {
                header('Location: ../wadaUsers/wadaUsersApplication/house_road_verification_view.php?wadaMemberHouseRoadFormID=' . $wadaMemberFormID . '');
            }
            exit();
        } else {
            $wadaApplicationID = $_GET['wadaApplicationID'];
            $wadaSentStatus = 'Sent';
            $wadaSentDateTime = date('Y-m-d H:i:s');

            $stmt = $mysqli->prepare("UPDATE `wadaconnectapplicationlisting` SET `wadaConnectApplicationWadaSentStatus`= ?, `wadaConnectApplicationWadaSentDateTime` = ? WHERE wadaConnectApplicationListingID = ? AND wadaConnectApplicationUserID = ?;");
            $stmt->bind_param('ssii', $wadaSentStatus, $wadaSentDateTime, $wadaApplicationID, $_SESSION['wadaMemberID']);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $_SESSION['status'] = 'success';
                $_SESSION['message'] = 'Application Sent to Wada Office.';
                if ($applicationType == 1) {
                    header('Location: ../wadaUsers/wadaUsersApplication/four_boundaries_certificate_view.php?wadaMemberFourBoundariesFormID=' . $wadaMemberFormID . '');
                } else if ($applicationType == 2) {
                    header('Location: ../wadaUsers/wadaUsersApplication/electricity_connection_recommendation_view.php?wadaMemberElectricityFormID=' . $wadaMemberFormID . '');
                } else if ($applicationType == 3) {
                    header('Location: ../wadaUsers/wadaUsersApplication/relation_certificate_verification_view.php?wadaMemberRelationFormID=' . $wadaMemberFormID . '');
                } else {
                    header('Location: ../wadaUsers/wadaUsersApplication/house_road_verification_view.php?wadaMemberHouseRoadFormID=' . $wadaMemberFormID . '');
                }
                exit();
            } else {
                $_SESSION['status'] = 'error';
                $_SESSION['message'] = 'Application not sent to Wada Office.';
                if ($applicationType == 1) {
                    header('Location: ../wadaUsers/wadaUsersApplication/four_boundaries_certificate_view.php?wadaMemberFourBoundariesFormID=' . $wadaMemberFormID . '');
                } else if ($applicationType == 2) {
                    header('Location: ../wadaUsers/wadaUsersApplication/electricity_connection_recommendation_view.php?wadaMemberElectricityFormID=' . $wadaMemberFormID . '');
                } else if ($applicationType == 3) {
                    header('Location: ../wadaUsers/wadaUsersApplication/relation_certificate_verification_view.php?wadaMemberRelationFormID=' . $wadaMemberFormID . '');
                } else {
                    header('Location: ../wadaUsers/wadaUsersApplication/house_road_verification_view.php?wadaMemberHouseRoadFormID=' . $wadaMemberFormID . '');
                }
                exit();
            }
        }

        $stmt->close();
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'No Application was selected.';
        header('Location: ../wadaUsers/application_submit.php');
        exit();
    }
} else {
    $_SESSION['status'] = 'error';
    $_SESSION['message'] = 'Database Connection Error.';
    header('Location: ../wadaUsers/application_submit.php');
    exit();
}

db_close($mysqli);
