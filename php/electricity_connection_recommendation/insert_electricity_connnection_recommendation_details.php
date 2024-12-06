<?php
require_once '../database_connection.php';

session_start();

if (isset($_SESSION['electricity_connection_form_data']) && !empty($_SESSION['electricity_connection_form_data'])) {
  $electricity_connection_data = $_SESSION['electricity_connection_form_data'][0];

  if (isset($_SESSION['wadaMemberID'])) {
    $wadaMemberID = $_SESSION['wadaMemberID'];
  } else {
    echo "User not logged in!";
    exit();
  }

  $source_document_location = "../../wadaMemberDocuments/session/";
  $destination_document_location = "../../wadaMemberDocuments/applicationDocuments/electricConnectionRecommendation/";

  $citizenship_document = $source_document_location . $electricity_connection_data['electricity-connection-citizenship-document']; 
  $land_ownership_document = $source_document_location . $electricity_connection_data['electricity-connection-land-ownership-document'];
  $land_map_document = $source_document_location . $electricity_connection_data['electricity-connection-land-map-document'];
  $land_tax_document = $source_document_location . $electricity_connection_data['electricity-connection-land-tax-document'];

  $citizenship_document_destination = $destination_document_location . $electricity_connection_data['electricity-connection-citizenship-document'];
  $land_ownership_document_destination = $destination_document_location . $electricity_connection_data['electricity-connection-land-ownership-document'];
  $land_map_document_destination = $destination_document_location . $electricity_connection_data['electricity-connection-land-map-document'];
  $land_tax_document_destination = $destination_document_location . $electricity_connection_data['electricity-connection-land-tax-document'];

  if (rename($citizenship_document, $citizenship_document_destination) && rename($land_ownership_document, $land_ownership_document_destination) && rename($land_map_document, $land_map_document_destination) && rename($land_tax_document, $land_tax_document_destination)) {
    echo "Files copied successfully!";
  } else {
    echo "File copy failed!";
  }

  $citizenship_document_destination = substr($citizenship_document_destination, 6);
  $land_ownership_document_destination = substr($land_ownership_document_destination, 6);
  $land_map_document_destination = substr($land_map_document_destination, 6);
  $land_tax_document_destination = substr($land_tax_document_destination, 6);

  $mysqli = db_connect();
  if ($mysqli) {
    $stmt = $mysqli->prepare("INSERT INTO `wadamemberelectricconnectiondata`(`wadaMemberElectricConnectionFormID`, `wadaMemberElectricConnectionUserID`, `wadaMemberElectricConnectionDistrict`, `wadaMemberElectricConnectionMunicipality`, `wadaMemberElectricConnectionMunicipalityType`, `wadaMemberElectricConnectionWard`, `wadaMemberElectricConnectionMapNo`, `wadaMemberElectricConnectionKittaNo`, `wadaMemberElectricConnectionArea`, `wadaMemberElectricConnectionCitizenshipDocument`, `wadaMemberElectricConnectionLandOwnershipDocument`, `wadaMemberElectricConnectionLandMapDocument`, `wadaMemberElectricConnectionLandTaxDocument`, `wadaMemberElectricConnectionSubmittedDateTime`) VALUES (NULL,?,?,?,?,?,?,?,?,?,?,?,?,CURRENT_TIMESTAMP)");

    if ($stmt) {
      $stmt->bind_param(
        "isssssssssss",
        $wadaMemberID,
        $electricity_connection_data['electricity-connection-district'],
        $electricity_connection_data['electricity-connection-municipality'],
        $electricity_connection_data['electricity-connection-municipality-type'],
        $electricity_connection_data['electricity-connection-ward'],
        $electricity_connection_data['electricity-connection-map'],
        $electricity_connection_data['electricity-connection-kitta-number'],
        $electricity_connection_data['electricity-connection-area'],
        $citizenship_document_destination,
        $land_ownership_document_destination,
        $land_map_document_destination,
        $land_tax_document_destination
      );

      if ($stmt->execute()) {
        echo "Data inserted successfully!";

        $applicationType = "2";
        $applicationWadaSentStatus = "Unsent";
        $applicationStatus = "Pending";

        $wadaConnectApplicationID = $mysqli->insert_id;
        $stmt->close();

        $stmt = $mysqli->prepare("INSERT INTO `wadaconnectapplicationlisting`(`wadaConnectApplicationListingID`, `wadaConnectApplicationID`, `wadaConnectApplicationUserID`, `wadaConnectApplicationType`, `wadaConnectApplicationWadaSentStatus`, `wadaConnectApplicationWadaSentDateTime`, `wadaConnectApplicationStatus`, `wadaConnectApplicationApprovedDocument`, `wadaConnectApplicationRemarks`, `wadaConnectApplicationDateTime`) VALUES (NULL,?,?,?,?,NULL,?,NULL,NULL,CURRENT_TIMESTAMP)");
        $stmt->bind_param("iisss", $wadaConnectApplicationID, $wadaMemberID, $applicationType, $applicationWadaSentStatus, $applicationStatus);

        if ($stmt->execute()) {
          echo "Data inserted successfully!";
          $stmt->close();
        } else {
          echo "Error inserting data: " . $stmt->error;
        }

        unset($_SESSION['electricity_connection_form_data']);
      } else {
        echo "Error inserting data: " . $stmt->error;
      }
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
