<?php
session_start();

if (!isset($_SESSION['userLoginStatus']) || $_SESSION['userLoginStatus'] !== true) {
    header('Location: ../login.php');
    exit;
}

if ($_SESSION['wadaMemberUserType'] == 3) {
    if ($_SESSION['wadaMemberID'] == 0) {
        echo "<script>alert('Please complete your profile first.');';</script>";
        header('Location: ../applicant_profile.php');
        exit;
    }
}

if (isset($_GET['wadaMemberElectricConnectionFormID']) && $_GET['wadaMemberID']) {
    $wadaMemberElectricConnectionFormID = $_GET['wadaMemberElectricConnectionFormID'];
    $wadaMemberID = $_GET['wadaMemberID'];
} else {
    echo "User not logged in!";
    exit();
}

require '../../assets/extensions/mpdf/autoload.php';
require '../../assets/extensions/laravel-ad-to-bs-converter/autoload.php';

require_once '../database_connection.php';

use Krishnahimself\DateConverter\DateConverter;

$mpdf = new \Mpdf\Mpdf();

$mpdf = new \Mpdf\Mpdf([
    'autoScriptToLang' => true,
    'autoLangToFont' => true
]);

$mpdf->SetTitle('Electric Connection Recommendation');
$mpdf->SetAuthor('Coders Inbox');
$mpdf->SetSubject('Recommendation for Electric Connection');
$mpdf->SetKeywords('Electricity, Connection, Recommendation, PDF');

function convertToNepaliNumber($englishNumber)
{
    $englishToNepali = [
        '0' => '०',
        '1' => '१',
        '2' => '२',
        '3' => '३',
        '4' => '४',
        '5' => '५',
        '6' => '६',
        '7' => '७',
        '8' => '८',
        '9' => '९',
    ];
    $nepaliNumber = strtr($englishNumber, $englishToNepali);
    return $nepaliNumber;
}

$mysqli = db_connect();
if ($mysqli) {
    $stmt = $mysqli->prepare("SELECT wadaConnnectOfficeID, wadaConnectOfficeProvince, wadaConnnectOfficeDistrict, wadaConnnectOfficeMunicipality, wadaConnectOfficeMunicipalityType FROM wadaconnectofficedetails WHERE wadaConnnectOfficeID = ?");
    if ($stmt) {
        $wadaConnectOfficeID = 1;
        $stmt->bind_param("i", $wadaConnectOfficeID);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($wadaConnnectOfficeID, $wadaConnectOfficeProvince, $wadaConnnectOfficeDistrict, $wadaConnnectOfficeMunicipality, $wadaConnectOfficeMunicipalityType);
        $stmt->fetch();
    }

    $stmt = $mysqli->prepare("SELECT * FROM `wadamemberelectricconnectiondata` WHERE wadaMemberElectricConnectionFormID = ?");
    if ($stmt) {
        $stmt->bind_param("i", $wadaMemberElectricConnectionFormID);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($wadaMemberElectricConnectionFormID, $wadaMemberElectricConnectionUserID, $wadaMemberElectricConnectionDistrict, $wadaMemberElectricConnectionMunicipality, $wadaMemberElectricConnectionMunicipalityType, $wadaMemberElectricConnectionWard, $wadaMemberElectricConnectionMapNo, $wadaMemberElectricConnectionKittaNo, $wadaMemberElectricConnectionArea, $wadaMemberElectricConnectionCitizenshipDocument, $wadaMemberElectricConnectionLandOwnershipDocument, $wadaMemberElectricConnectionLandMapDocument, $wadaMemberElectricConnectionLandTaxDocument, $wadaMemberElectricConnectionSubmittedDateTime);
        $stmt->fetch();
    }

    $stmt = $mysqli->prepare("SELECT wadaMemberFirstNameNP, wadaMemberMiddleNameNP, wadaMemberLastNameNP, wadaMemberPermanentMunicipality, wadaMemberPermanentDistrict, wadaMemberDocumentTypeSignature FROM wadamemberpersonaldetails INNER JOIN wadamemberaddressdetails ON wadaMemberID = wadaMemberAddressDetailsID INNER JOIN wadamembernepalidetails ON wadaMemberID = wadaMemberNepaliDetailsID INNER JOIN wadamembersdocumentdetails ON wadaMemberID = wadaMemberDocumentDetailsID WHERE wadaMemberID = ?");
    if ($stmt) {
        $stmt->bind_param("i", $wadaMemberElectricConnectionUserID);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($wadaMemberFirstNameNP, $wadaMemberMiddleNameNP, $wadaMemberLastNameNP, $wadaMemberPermanentMunicipality, $wadaMemberPermanentDistrict, $wadaMemberDocumentTypeSignature);
        $stmt->fetch();
    }

    $sql = "SELECT `districtNepaliName` FROM `wadaconnectdistrictnepal` WHERE districtEnglishName = '$wadaConnnectOfficeDistrict'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $wadaConnnectOfficeDistrict = $row['districtNepaliName'];

    $sql = "SELECT localLevelNepaliName FROM wadaconnectlocallevelnepal WHERE localLevelEnglishName = '$wadaConnnectOfficeMunicipality'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $wadaConnnectOfficeMunicipality = $row['localLevelNepaliName'];

    $sql = "SELECT localLevelNepaliName FROM wadaconnectlocallevelnepal WHERE localLevelEnglishName = '$wadaMemberElectricConnectionMunicipality'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $wadaMemberElectricConnectionMunicipality = $row['localLevelNepaliName'];

    $sql = "SELECT districtNepaliName FROM wadaconnectdistrictnepal WHERE districtEnglishName = '$wadaMemberElectricConnectionDistrict'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $wadaMemberElectricConnectionDistrict = $row['districtNepaliName'];

    $sql = "SELECT `districtNepaliName` FROM `wadaconnectdistrictnepal` WHERE districtEnglishName = '$wadaMemberPermanentDistrict'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $wadaMemberPermanentDistrict = $row['districtNepaliName'];

    $sql = "SELECT localLevelNepaliName FROM wadaconnectlocallevelnepal WHERE localLevelEnglishName = '$wadaMemberPermanentMunicipality'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $wadaMemberPermanentMunicipality = $row['localLevelNepaliName'];

    $stmt->close();
}

if ($wadaConnectOfficeMunicipalityType == "Metropolitan") {
    $wadaConnectOfficeMunicipalityType = "महानगरपालिका";
} else if ($wadaConnectOfficeMunicipalityType == "Sub-Metropolitan") {
    $wadaConnectOfficeMunicipalityType = "उप-महानगरपालिका";
} else if ($wadaConnectOfficeMunicipalityType == "Municipality") {
    $wadaConnectOfficeMunicipalityType = "नगरपालिका";
}

if ($wadaMemberElectricConnectionMunicipalityType == "Metropolitan") {
    $wadaMemberElectricConnectionMunicipalityType = "महानगरपालिका";
} else if ($wadaMemberElectricConnectionMunicipalityType == "Sub-Metropolitan") {
    $wadaMemberElectricConnectionMunicipalityType = "उप-महानगरपालिका";
} else if ($wadaMemberElectricConnectionMunicipalityType == "Municipality") {
    $wadaMemberElectricConnectionMunicipalityType = "नगरपालिका";
}

$dateTimeParts = explode(' ', $wadaMemberElectricConnectionSubmittedDateTime);
$dateParts = explode('-', $dateTimeParts[0]);

$submittedYear = $dateParts[0];
$submittedMonth = $dateParts[1];
$submittedDay = $dateParts[2];

$nepaliDate = DateConverter::fromEnglishDate($submittedYear, $submittedMonth, $submittedDay)->toFormattedNepaliDate();

$nepaliDate = explode(',', $nepaliDate)[0];

$wadaMemberElectricConnectionWard = convertToNepaliNumber($wadaMemberElectricConnectionWard);
$wadaMemberElectricConnectionMapNo = convertToNepaliNumber($wadaMemberElectricConnectionMapNo);
$wadaMemberElectricConnectionKittaNo = convertToNepaliNumber($wadaMemberElectricConnectionKittaNo);
$wadaMemberElectricConnectionArea = convertToNepaliNumber($wadaMemberElectricConnectionArea);

$mpdf->WriteHTML('<p style="text-align: right; font-size: 20px;">मिति: ' . $nepaliDate . '</p>');
$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;">श्रीमान वडा प्रमुख ज्यु,</p>');
$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;"> ' . $wadaConnnectOfficeMunicipality . ' ' . $wadaConnectOfficeMunicipalityType . ' कार्यालय,</p>');
$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;"> ' . $wadaConnnectOfficeDistrict . ' जिल्ला ।</p>');

$mpdf->WriteHTML('<p style="text-align: center; font-size: 20px;">विषय: विद्युत मिटर जडानको लागि सिफारिस गरि पाउँ।।</p>');

$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;">महोदय, </p>');

$mpdf->WriteHTML('<p style="text-align: justify; font-size: 20px;"> उपर्युक्त सम्बन्धमा निवेदन यो छ की मेरो नाम मा दर्ता रहेको ' . $wadaMemberElectricConnectionDistrict . ' जिल्ला ' . $wadaMemberElectricConnectionMunicipality . ' ' . $wadaMemberElectricConnectionMunicipalityType . ' वडा नो. ' . $wadaMemberElectricConnectionWard . ' मा पर्ने नक्सा नं. ' . $wadaMemberElectricConnectionMapNo . ' र कित्ता नं. ' . $wadaMemberElectricConnectionKittaNo . ' छेत्रफल ' . $wadaMemberElectricConnectionArea . ' भएको जग्गामा निर्मित रहेको घरमा विद्युत मिटर जडान गर्न आवश्यक भएकोले सो का लागि सम्बन्धित विद्युत प्राधिकरण सिफारिस गरी पाउन निवेदन गर्दछु ।</p>');

$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;">निवेदक,</p>');
$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;">सही : </p>');

if ($_SESSION['wadaMemberUserType'] == 2) {
    $signature = '<p style="text-align: left; font-size: 20px;"><img src="../../' . $wadaMemberDocumentTypeSignature . '" style="width: 100px; vertical-align: middle;" alt="Signature"></p>';
    $mpdf->WriteHTML($signature);
}

$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;">नाम: ' . $wadaMemberFirstNameNP . ' ' . $wadaMemberMiddleNameNP . ' ' . $wadaMemberLastNameNP . '</p>');
$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;">ठेगाना: ' . $wadaMemberPermanentMunicipality . ', ' . $wadaMemberPermanentDistrict . '</p>');

if ($_SESSION['wadaMemberUserType'] == 2) {
    $mpdf->AddPage();

    $mpdf->WriteHTML('<p style="text-align: center; font-size: 20px;">नागरिकता कागजात</p>');
    $applicant_citizenship = '<img src="../../' . $wadaMemberElectricConnectionCitizenshipDocument . '" style="vertical-align: middle;" alt="Citizenship Of Applicant">';
    $mpdf->WriteHTML($applicant_citizenship);

    $mpdf->AddPage();
    $mpdf->WriteHTML('<p style="text-align: center; font-size: 20px;">जग्गाको स्वामित्वको कागजात</p>');
    $applicant_land_ownership = '<img src="../../' . $wadaMemberElectricConnectionLandOwnershipDocument . '" style="vertical-align: middle;" alt="Land Ownership Document Of Applicant">';
    $mpdf->WriteHTML($applicant_land_ownership);

    $mpdf->AddPage();
    $mpdf->WriteHTML('<p style="text-align: center; font-size: 20px;">जग्गाको नक्सा</p>');
    $applicant_land_map = '<img src="../../' . $wadaMemberElectricConnectionLandMapDocument . '" style="vertical-align: middle;" alt="Citizenship Of Applicant">';
    $mpdf->WriteHTML($applicant_land_map);

    $mpdf->AddPage();
    $mpdf->WriteHTML('<p style="text-align: center; font-size: 20px;">जग्गाको कर रसिद</p>');
    $applicant_land_tax = '<img src="../../' . $wadaMemberElectricConnectionLandTaxDocument . '" style="vertical-align: middle;" alt="Citizenship Of Applicant">';
    $mpdf->WriteHTML($applicant_land_tax);
}

$electricConnectionFileName = "Electric_Connection_Recommendation_" . $wadaMemberFirstNameNP . "_" . $wadaMemberLastNameNP . ".pdf";
$mpdf->Output($electricConnectionFileName, 'I');

db_close($mysqli);
?>