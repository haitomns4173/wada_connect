<?php
require_once '../database_connection.php';

session_start();

if (isset($_SESSION['four_boundaries_form_data']) && !empty($_SESSION['four_boundaries_form_data'])) {
  $four_boundries_value = $_SESSION['four_boundaries_form_data'][0];

  if (isset($_SESSION['wadaMemberID'])) {
    $wadaMemberID = $_SESSION['wadaMemberID'];
  } else {
    echo "User not logged in!";
    exit();
  }

  $source_document_location = "../../wadaMemberDocuments/session/";
  $destination_document_location = "../../wadaMemberDocuments/applicationDocuments/fourBoundariesCertificate/";

  $citizenship_document = $source_document_location . $four_boundries_value['four_boundaries_citizenship_column'];
  $land_ownership_document = $source_document_location . $four_boundries_value['four_boundaries_land_ownership_column'];
  $land_map_document = $source_document_location . $four_boundries_value['four_boundaries_land_map_column'];
  $land_tax_document = $source_document_location . $four_boundries_value['four_boundaries_land_tax_column'];

  $citizenship_document_destination = $destination_document_location . $four_boundries_value['four_boundaries_citizenship_column'];
  $land_ownership_document_destination = $destination_document_location . $four_boundries_value['four_boundaries_land_ownership_column'];
  $land_map_document_destination = $destination_document_location . $four_boundries_value['four_boundaries_land_map_column'];
  $land_tax_document_destination = $destination_document_location . $four_boundries_value['four_boundaries_land_tax_column'];

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
    $stmt = $mysqli->prepare("INSERT INTO `wadamemberfourboundariesdata`(`wadaMemberFourBoundariesFormID`, `wadaMemberFourBoundariesUserID`, `wadaMemberFourBoundariesDistrict`, `wadaMemberFourBoundariesMunicipality`, `wadaMemberFourBoundariesMunicipalityType`, `wadaMemberFourBoundariesWard`, `wadaMemberFourBoundariesKittaNo`, `wadaMemberFourBoundariesArea`, `wadaMemberFourBoundariesEastPersonName`, `wadaMemberFourBoundariesEast`, `wadaMemberFourBoundariesWestPersonName`, `wadaMemberFourBoundariesWest`, `wadaMemberFourBoundariesNorthPersonName`, `wadaMemberFourBoundariesNorth`, `wadaMemberFourBoundariesSouthPersonName`, `wadaMemberFourBoundariesSouth`, `wadaMemberFourBoundariesCitizenshipDocument`, `wadaMemberFourBoundariesLandOwnershipDocument`, `wadaMemberFourBoundariesLandMapDocument`, `wadaMemberFourBoundariesLandTaxDocument`, `wadaMemberFourBoundariesSubmittedDateTime`) VALUES (NULL,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,CURRENT_TIMESTAMP)");
    if ($stmt) {
      $stmt->bind_param(
        "issssssssssssssssss",
        $wadaMemberID,
        $four_boundries_value['four_boundaries_district'],
        $four_boundries_value['four_boundaries_municipality'],
        $four_boundries_value['four_boundaries_municipality_type'],
        $four_boundries_value['four_boundaries_ward'],
        $four_boundries_value['four_boundaries_kitta_number'],
        $four_boundries_value['four_boundaries_area'],
        $four_boundries_value['four_boundaries_east_person_name'],
        $four_boundries_value['four_boundaries_east'],
        $four_boundries_value['four_boundaries_west_person_name'],
        $four_boundries_value['four_boundaries_west'],
        $four_boundries_value['four_boundaries_north_person_name'],
        $four_boundries_value['four_boundaries_north'],
        $four_boundries_value['four_boundaries_south_person_name'],
        $four_boundries_value['four_boundaries_south'],
        $citizenship_document_destination,
        $land_ownership_document_destination,
        $land_map_document_destination,
        $land_tax_document_destination
      );

      if ($stmt->execute()) {
        echo "Data inserted successfully!";

        $applicationType = "1";
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

        unset($_SESSION['four_boundaries_form_data']);
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
