<?php
require_once '../database_connection.php';

session_start();

if (isset($_SESSION['relation_certificate_verification_form_data'])) {
    if (!empty($_SESSION['relation_certificate_verification_form_data'])) {
        $relation_certificate_verification_data = $_SESSION['relation_certificate_verification_form_data'][0];

        if (isset($_SESSION['wadaMemberID'])) {
            $wadaMemberID = $_SESSION['wadaMemberID'];
        } else {
            echo "User not logged in!";
            exit();
        }

        $source_citizenship_document = "../../wadaMemberDocuments/session/" . $relation_certificate_verification_data['relation_certification_citizenship_column'];
        $destination_citizenship_document = "../../wadaMemberDocuments/applicationDocuments/relationCertificateVerification/" . $relation_certificate_verification_data['relation_certification_citizenship_column'];

        if (rename($source_citizenship_document, $destination_citizenship_document)) {
            echo "File copied successfully!";
        } else {
            echo "File copy failed!";
        }

        $destination_citizenship_document = substr($destination_citizenship_document, 6);

        $mysqli = db_connect();
        if ($mysqli) {
            $stmt = $mysqli->prepare("INSERT INTO `wadamemberrelationdetails` (`wadaMemberRelationFormID`, `wadaMemberRelationUserID`, `wadaMemberRelationFullName`, `wadaMemberRelationAge`, `wadaMemberRelationGender`, `wadaMemberRelationShip`, `wadaMemberRelationDistrict`, `wadaMemberRelationMunicipality`, `wadaMemberRelationMunicipalityType`, `wadaMemberRelationWard`, `wadaMemberRelationCitizenshipDocument`, `wadaMemberRelationSubmittedDateTime`) VALUES (NULL,?,?,?,?,?,?,?,?,?,?,CURRENT_TIMESTAMP)");

            if ($stmt) {
                $stmt->bind_param(
                    "isssssssss",
                    $wadaMemberID,
                    $relation_certificate_verification_data['relation_certificate_name_column'],
                    $relation_certificate_verification_data['relation_certificate_age_column'],
                    $relation_certificate_verification_data['relation_certificate_gender_column'],
                    $relation_certificate_verification_data['relation_certification_relationship_column'],
                    $relation_certificate_verification_data['relation_certification_district_column'],
                    $relation_certificate_verification_data['relation_certification_municipality_column'],
                    $relation_certificate_verification_data['relation_certification_municipality_type_column'],
                    $relation_certificate_verification_data['relation_certification_ward_column'],
                    $destination_citizenship_document
                );

                if ($stmt->execute()) {
                    echo "Data inserted successfully!";
                } else {
                    echo "Error inserting data: " . $stmt->error;
                }

                $wadaConnectApplicationID = $mysqli->insert_id;
                $stmt->close();

                $applicationType = "3";
                $applicationWadaSentStatus = "Unsent";
                $applicationStatus = "Pending";

                $stmt = $mysqli->prepare("INSERT INTO `wadaconnectapplicationlisting`(`wadaConnectApplicationListingID`, `wadaConnectApplicationID`, `wadaConnectApplicationUserID`, `wadaConnectApplicationType`, `wadaConnectApplicationWadaSentStatus`, `wadaConnectApplicationWadaSentDateTime`, `wadaConnectApplicationStatus`, `wadaConnectApplicationApprovedDocument`, `wadaConnectApplicationRemarks`, `wadaConnectApplicationDateTime`) VALUES (NULL,?,?,?,?,NULL,?,NULL,NULL,CURRENT_TIMESTAMP)");
                $stmt->bind_param("iisss", $wadaConnectApplicationID, $wadaMemberID, $applicationType, $applicationWadaSentStatus, $applicationStatus);

                if ($stmt->execute()) {
                    echo "Application listing inserted successfully!";
                    $stmt->close();
                } else {
                    echo "Error inserting application listing: " . $stmt->error;
                }

                unset($_SESSION['relation_certificate_verification_form_data']);
                echo "Session data cleared!";
            } else {
                echo "Error preparing statement: " . $mysqli->error;
            }

            db_close($mysqli);
        } else {
            echo "Database connection failed.";
        }
    } else {
        echo "No data to insert!";
    }
} else {
    echo "No data to insert!";
}
