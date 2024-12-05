<?php
require_once 'database_connection.php';

$wadaMemberID = $_SESSION['wadaMemberID'];

$mysqli = db_connect();
$stmt = $mysqli->prepare("SELECT * FROM `wadaconnectapplicationlisting` INNER JOIN `wadaconnectapplicationtype` ON wadaConnectApplicationType = wadaConnectApplicationTypeID WHERE wadaConnectApplicationUserID =  ? ORDER BY wadaConnectApplicationListingID DESC;");
$stmt->bind_param("i", $wadaMemberID);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

$applicationCounter = 1;

if ($result->num_rows == 0) {
  echo "<tr>";
  echo "<tr><td colspan='6'><center>No Applications Submitted</center></td></tr>";
  echo "</tr>";
} else {
  foreach ($result as $row) {
    echo "<tr>";
    echo "<td>" . $applicationCounter++ . "</td>";
    echo "<td>" . $row['wadaConnectApplicationListingID'] . " - " . $row['wadaConnectApplicationID'] . " - " . $row['wadaConnectApplicationUserID'] . " - " . $row['wadaConnectApplicationType'] . "</td>";
    echo "<td>" . $row['wadaConnectApplicationTypeName'] . "</td>";
    echo "<td>" . $row['wadaConnectApplicationDateTime'] . "</td>";
    echo "<td>";
    if ($row['wadaConnectApplicationStatus'] == 'Pending') {
      echo "<span class='badge bg-light-primary'> " . $row['wadaConnectApplicationStatus'] . "</span>";
    } else if ($row['wadaConnectApplicationStatus'] == 'Processing') {
      echo "<span class='badge bg-light-warning'> " . $row['wadaConnectApplicationStatus'] . "</span>";
    } else if ($row['wadaConnectApplicationStatus'] == 'Approved') {
      echo "<span class='badge bg-light-success'> " . $row['wadaConnectApplicationStatus'] . "</span>";
    } else if ($row['wadaConnectApplicationStatus'] == 'Rejected') {
      echo "<span class='badge bg-light-danger'> " . $row['wadaConnectApplicationStatus'] . "</span>";
    }
    echo "</td>";
    if ($row['wadaConnectApplicationType'] == 1) {
      echo "<td>
            <a href='../php/four_boundries_certificate/four_boundries_certificate_print.php?wadaMemberFourBoundariesFormID=" . $row['wadaConnectApplicationID'] . "&wadaMemberID=" . $row['wadaConnectApplicationUserID'] . "' class='btn icon btn-success' target='_blank'> <i class='bi bi-download'></i></a>
            <a href='wadaUsersApplication/four_boundaries_certificate_view.php?wadaMemberFourBoundariesFormID=" . $row['wadaConnectApplicationID'] . "' class='btn icon btn-primary'> <i class='bi bi-eye'></i></a>
            </td>";
    } else if ($row['wadaConnectApplicationType'] == 2) {
      echo "<td>
            <a href='../php/electricity_connection_recommendation/electricity_connection_recommendation_print.php?wadaMemberElectricConnectionFormID=" . $row['wadaConnectApplicationID'] . "&wadaMemberID=" . $row['wadaConnectApplicationUserID'] . "' class='btn icon btn-success' target='_blank'> <i class='bi bi-download'></i></a>
            <a href='wadaUsersApplication/electricity_connection_recommendation_view.php?wadaMemberElectricityFormID=" . $row['wadaConnectApplicationID'] . "' class='btn icon btn-primary'> <i class='bi bi-eye'></i></a>
            </td>";
    } else if ($row['wadaConnectApplicationType'] == 3) {
      echo "<td>
            <a href='../php/relation_certificate_verification/relation_certificate_verification_print.php?wadaMemberRelationVerificationFormID=" . $row['wadaConnectApplicationID'] . "&wadaMemberID=" . $row['wadaConnectApplicationUserID'] . "' class='btn icon btn-success' target='_blank'> <i class='bi bi-download'></i></a>
            <a href='wadaUsersApplication/relation_certificate_verification_view.php?wadaMemberRelationFormID=" . $row['wadaConnectApplicationID'] . "' class='btn icon btn-primary'> <i class='bi bi-eye'></i></a>
            </td>";
    } else {
      echo "<td>
            <a href='../php/house_road_verification/house_road_verification_print.php?wadaMemberHouseRoadFormID=" . $row['wadaConnectApplicationID'] . "&wadaMemberID=" . $row['wadaConnectApplicationUserID'] . "' class='btn icon btn-success' target='_blank'> <i class='bi bi-download'></i></a>
            <a href='wadaUsersApplication/house_road_verification_view.php?wadaMemberHouseRoadFormID=" . $row['wadaConnectApplicationID'] . "' class='btn icon btn-primary'> <i class='bi bi-eye'></i></a>
            </td>";
    }
    echo "</tr>";
  }
}

$mysqli->close();
