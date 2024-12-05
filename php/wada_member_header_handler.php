<?php
require '../assets/extensions/laravel-ad-to-bs-converter/autoload.php';
require_once 'database_connection.php';

use Krishnahimself\DateConverter\DateConverter;

$mysqli = db_connect();

if (empty($wadaADTodayDate)) {
    $wadaADTodayDate = date("Y-m-d");
}

$formattedADDate = date("d F Y, l", strtotime($wadaADTodayDate));

$submittedYear = date("Y", strtotime($wadaADTodayDate));
$submittedMonth = date("m", strtotime($wadaADTodayDate));
$submittedDay = date("d", strtotime($wadaADTodayDate));
$nepaliDate = DateConverter::fromEnglishDate($submittedYear, $submittedMonth, $submittedDay)->toFormattedNepaliDate();

if($_SESSION['wadaMemberID'] == 0){
  $wadaMemberImage = "../assets/compiled/jpg/avatars/wadaNewUser.webp";

  $wadaMemberFirstName = "New";
  $wadaMemberMiddleName = " ";
  $wadaMemberLastName = "User";
}
else{
    $stmt = $mysqli->prepare("SELECT `wadaMemberFirstName`, `wadaMemberMiddleName`, `wadaMemberLastName` FROM `wadamemberpersonaldetails` WHERE wadaMemberID = ?");
    $stmt->bind_param('i', $_SESSION['wadaMemberID']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($wadaMemberFirstName, $wadaMemberMiddleName, $wadaMemberLastName);
    $stmt->fetch();
    $stmt->close();

    $stmt = $mysqli->prepare("SELECT `wadaMemberDocumentTypeProfilePicture` FROM `wadamembersdocumentdetails` WHERE wadaMemberDocumentDetailsID = ?;");
    $stmt->bind_param('i', $_SESSION['wadaMemberID']);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($wadaMemberImage);
    $stmt->fetch();
    $stmt->close();

    if(empty($wadaMemberImage)){
        $wadaMemberImage = "../assets/compiled/jpg/avatars/wadaNewUser.webp";
    }
    else{
        $wadaMemberImage = "../" . $wadaMemberImage;
    } 
}

db_close($mysqli);
?>