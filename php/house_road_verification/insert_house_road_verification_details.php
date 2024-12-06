<?php
require_once '../database_connection.php';

session_start();

if (isset($_SESSION['house_road_verification_form_data']) && !empty($_SESSION['house_road_verification_form_data'])) {
  $house_road_verification_data = $_SESSION['house_road_verification_form_data'][0];

  if (isset($_SESSION['wadaMemberID'])) {
    $wadaMemberID = $_SESSION['wadaMemberID'];
  } else {
    echo "User not logged in!";
    exit();
  }

  $source_document_location = "../../wadaMemberDocuments/session/";
  $destination_document_location = "../../wadaMemberDocuments/applicationDocuments/houseRoadVerification/";

  $citizenship_document = $source_document_location . $house_road_verification_data['house_road_verification_citizenship_column'];
  $land_ownership_document = $source_document_location . $house_road_verification_data['house_road_verification_land_ownership_column'];
  $land_map_document = $source_document_location . $house_road_verification_data['house_road_verification_land_map_column'];
  $land_tax_document = $source_document_location . $house_road_verification_data['house_road_verification_land_tax_column'];

  $citizenship_document_destination = $destination_document_location . $house_road_verification_data['house_road_verification_citizenship_column'];
  $land_ownership_document_destination = $destination_document_location . $house_road_verification_data['house_road_verification_land_ownership_column'];
  $land_map_document_destination = $destination_document_location . $house_road_verification_data['house_road_verification_land_map_column'];
  $land_tax_document_destination = $destination_document_location . $house_road_verification_data['house_road_verification_land_tax_column'];

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
    $stmt = $mysqli->prepare("INSERT INTO `wadamemberhouseroaddetails`(`wadaMemberHouseRoadFormID`, `wadaMemberHouseRoadUserID`, `wadaMemberHouseRoadDistrict`, `wadaMemberHouseRoadMunicipality`, `wadaMemberHouseRoadMunicipalityType`, `wadaMemberHouseRoadWard`, `wadaMemberHouseRoadMapNo`, `wadaMemberHouseRoadKittaNo`, `wadaMemberHouseRoadArea`, `wadaMemberHouseRoadRoadPresence`, `wadaMemberHouseRoadHouseBuyerName`, `wadaMemberHouseRoadBuyerSpouseName`, `wadaMemberHouseRoadBuyerCitizenshipNo`, `wadaMemberHouseRoadBuyerCitizenshipDistrict`, `wadaMemberHouseRoadBuyerProvince`, `wadaMemberHouseRoadBuyerDistrict`, `wadaMemberHouseRoadBuyerMunicipality`, `wadaMemberHouseRoadBuyerWard`, `wadaMemberHouseRoadCitizenshipDocument`, `wadaMemberHouseRoadLandOwnershipDocument`, `wadaMemberHouseRoadLandMapDocument`, `wadaMemberHouseRoadLandTaxDocument`, `wadaMemberHouseRoadSubmittedDateTime`) VALUES (NULL,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,CURRENT_TIMESTAMP)");

    if ($stmt) {
      $stmt->bind_param(
        "issssssssssssssssssss",
        $wadaMemberID,
        $house_road_verification_data['house_road_verification_district_column'],
        $house_road_verification_data['house_road_verification_municipality_column'],
        $house_road_verification_data['house_road_verification_municipality_type_column'],
        $house_road_verification_data['house_road_verification_ward_column'],
        $house_road_verification_data['house_road_verification_map_column'],
        $house_road_verification_data['house_road_verification_kitta_number_column'],
        $house_road_verification_data['house_road_verification_area_column'],
        $house_road_verification_data['house_road_verification_road_presence_column'],
        $house_road_verification_data['house_road_verification_land_buyer_name_column'],
        $house_road_verification_data['house_road_verification_land_buyer_spouse_name_column'],
        $house_road_verification_data['house_road_verification_land_buyer_citizenship_number_column'],
        $house_road_verification_data['house_road_verification_land_buyer_citizenship_district_column'],
        $house_road_verification_data['house_road_verification_land_buyer_province_column'],
        $house_road_verification_data['house_road_verification_land_buyer_district_column'],
        $house_road_verification_data['house_road_verification_land_buyer_municipality_column'],
        $house_road_verification_data['house_road_verification_land_buyer_ward_column'],
        $citizenship_document_destination,
        $land_ownership_document_destination,
        $land_map_document_destination,
        $land_tax_document_destination
      );

      if ($stmt->execute()) {
        echo "Data inserted successfully!";
      } else {
        echo "Error inserting data: " . $stmt->error;
      }

      $wadaConnectApplicationID = $mysqli->insert_id;
      $stmt->close();

      $applicationType = "4";
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

      unset($_SESSION['house_road_verification_form_data']);
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