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

if (isset($_GET['wadaMemberHouseRoadFormID']) && isset($_GET['wadaMemberID'])) {
    $wadaMemberHouseRoadFormID = $_GET['wadaMemberHouseRoadFormID'];
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

$mpdf->SetTitle('House Road Verification');
$mpdf->SetAuthor('Coders Inbox');
$mpdf->SetSubject('Verification of House & Road');
$mpdf->SetKeywords('House Road, Verification, PDF');

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

    $stmt = $mysqli->prepare("SELECT * FROM wadamemberhouseroaddetails WHERE wadaMemberHouseRoadFormID = ?");
    if ($stmt) {
        $stmt->bind_param("i", $wadaMemberHouseRoadFormID);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($wadaMemberHouseRoadFormID, $wadaMemberHouseRoadUserID, $wadaMemberHouseRoadDistrict, $wadaMemberHouseRoadMunicipality, $wadaMemberHouseRoadMunicipalityType, $wadaMemberHouseRoadWard, $wadaMemberHouseRoadMapNo, $wadaMemberHouseRoadKittaNo, $wadaMemberHouseRoadArea, $wadaMemberHouseRoadRoadPresence, $wadaMemberHouseRoadHouseBuyerName, $wadaMemberHouseRoadBuyerSpouseName, $wadaMemberHouseRoadBuyerCitizenshipNo, $wadaMemberHouseRoadBuyerCitizenshipDistrict, $wadaMemberHouseRoadBuyerProvince, $wadaMemberHouseRoadBuyerDistrict, $wadaMemberHouseRoadBuyerMunicipality, $wadaMemberHouseRoadBuyerWard, $wadaMemberHouseRoadCitizenshipDocument, $wadaMemberHouseRoadLandOwnershipDocument, $wadaMemberHouseRoadLandMapDocument, $wadaMemberHouseRoadLandTaxDocument, $wadaMemberHouseRoadSubmittedDateTime);
        $stmt->fetch();
    }

    $stmt = $mysqli->prepare("SELECT wadaMemberFirstNameNP, wadaMemberMiddleNameNP, wadaMemberLastNameNP, wadaMemberPermanentMunicipality, wadaMemberPermanentDistrict, wadaMemberPermanentProvince, wadaMemberCitizenshipNumber, wadaMemberCitizenshipIssuedDistrict, wadaMemberSpouseNameNP, wadaMemberDocumentTypeSignature FROM wadamemberpersonaldetails INNER JOIN wadamemberaddressdetails ON wadaMemberID = wadaMemberAddressDetailsID INNER JOIN wadamembernepalidetails ON wadaMemberID = wadaMemberNepaliDetailsID INNER JOIN wadamembercitizenshipdetails ON wadaMemberID=wadaMemberCitizenshipDetailsID INNER JOIN wadamembersdocumentdetails ON wadaMemberID = wadaMemberDocumentDetailsID WHERE wadaMemberID = ?;");
    if ($stmt) {
        $stmt->bind_param("i", $wadaMemberHouseRoadUserID);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($wadaMemberFirstNameNP, $wadaMemberMiddleNameNP, $wadaMemberLastNameNP, $wadaMemberPermanentMunicipality, $wadaMemberPermanentDistrict, $wadaMemberPermanentProvince, $wadaMemberCitizenshipNumber, $wadaMemberCitizenshipIssuedDistrict, $wadaMemberSpouseNameNP, $wadaMemberDocumentTypeSignature);
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

    $sql = "SELECT `localLevelNepaliName` FROM `wadaconnectlocallevelnepal` WHERE localLevelEnglishName = '$wadaMemberHouseRoadMunicipality'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $wadaMemberHouseRoadMunicipality = $row['localLevelNepaliName'];

    $sql = "SELECT `provinceNepaliName` FROM `wadaconnectprovincenepal` WHERE provinceEnglishName = '$wadaMemberPermanentProvince'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $wadaMemberPermanentProvince = $row['provinceNepaliName'];

    $sql = "SELECT `districtNepaliName` FROM `wadaconnectdistrictnepal` WHERE districtEnglishName = '$wadaMemberPermanentDistrict'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $wadaMemberPermanentDistrict = $row['districtNepaliName'];

    $sql = "SELECT `localLevelNepaliName` FROM `wadaconnectlocallevelnepal` WHERE localLevelEnglishName = '$wadaMemberPermanentMunicipality'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $wadaMemberPermanentMunicipality = $row['localLevelNepaliName'];

    $sql = "SELECT `provinceNepaliName` FROM `wadaconnectprovincenepal` WHERE provinceEnglishName = '$wadaMemberHouseRoadBuyerProvince'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $wadaMemberHouseRoadBuyerProvince = $row['provinceNepaliName'];

    $sql = "SELECT `districtNepaliName` FROM `wadaconnectdistrictnepal` WHERE districtEnglishName = '$wadaMemberHouseRoadBuyerDistrict'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $wadaMemberHouseRoadBuyerDistrict = $row['districtNepaliName'];

    $sql = "SELECT `localLevelNepaliName` FROM `wadaconnectlocallevelnepal` WHERE localLevelEnglishName = '$wadaMemberHouseRoadBuyerMunicipality'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $wadaMemberHouseRoadBuyerMunicipality = $row['localLevelNepaliName'];

    $sql = "SELECT `districtNepaliName` FROM `wadaconnectdistrictnepal` WHERE districtEnglishName = '$wadaMemberHouseRoadBuyerCitizenshipDistrict'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $wadaMemberHouseRoadBuyerCitizenshipDistrict = $row['districtNepaliName'];

    $sql = "SELECT `districtNepaliName` FROM `wadaconnectdistrictnepal` WHERE districtEnglishName = '$wadaMemberCitizenshipIssuedDistrict'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $wadaMemberCitizenshipIssuedDistrict = $row['districtNepaliName'];

    $stmt->close();
}

if ($wadaConnectOfficeMunicipalityType == "Metropolitan") {
    $wadaConnectOfficeMunicipalityType = "महानगरपालिका";
} else if ($wadaConnectOfficeMunicipalityType == "Sub-Metropolitan") {
    $wadaConnectOfficeMunicipalityType = "उप-महानगरपालिका";
} else if ($wadaConnectOfficeMunicipalityType == "Municipality") {
    $wadaConnectOfficeMunicipalityType = "नगरपालिका";
}

$wadaMemberHouseRoadWard = convertToNepaliNumber($wadaMemberHouseRoadWard);
$wadaMemberHouseRoadMapNo = convertToNepaliNumber($wadaMemberHouseRoadMapNo);
$wadaMemberHouseRoadKittaNo = convertToNepaliNumber($wadaMemberHouseRoadKittaNo);
$wadaMemberHouseRoadArea = convertToNepaliNumber($wadaMemberHouseRoadArea);

$wadaMemberHouseRoadBuyerCitizenshipNo = convertToNepaliNumber($wadaMemberHouseRoadBuyerCitizenshipNo);
$wadaMemberCitizenshipNumber = convertToNepaliNumber($wadaMemberCitizenshipNumber);

$wadaMemberHouseRoadRoadPresence = ($wadaMemberHouseRoadRoadPresence == "Yes") ? "भएको" : "नभएको";

$dateTimeParts = explode(' ', $wadaMemberHouseRoadSubmittedDateTime);
$dateParts = explode('-', $dateTimeParts[0]);

$submittedYear = $dateParts[0];
$submittedMonth = $dateParts[1];
$submittedDay = $dateParts[2];

$nepaliDate = DateConverter::fromEnglishDate($submittedYear, $submittedMonth, $submittedDay)->toFormattedNepaliDate();

$nepaliDate = explode(',', $nepaliDate)[0];

$mpdf->WriteHTML('<p style="text-align: right; font-size: 20px;">मिति: ' . $nepaliDate . '</p>');
$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;">श्रीमान वडा प्रमुख ज्यु,</p>');
$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;"> ' . $wadaConnnectOfficeMunicipality . ' ' . $wadaConnectOfficeMunicipalityType . ' कार्यालय,</p>');
$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;"> ' . $wadaConnnectOfficeDistrict . ' जिल्ला ।</p>');

$mpdf->WriteHTML('<p style="text-align: center; font-size: 20px;">विषय: घर/बाटो प्रमणित गरी पाउँ ।</p>');

$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;">महोदय, </p>');

$mpdf->WriteHTML('<p style="text-align: justify; font-size: 20px;"> उपरोक्त विषयमा देहायको जग्गाको मालपोत कार्यलयमा रजिष्ट्रेशन प्रयोजनको लागि घर/बाटो भए नभएको प्रमाणित विवरण आवश्यक भएकोले खुलाई प्रमाणित गरि दिनुहुन निवेदन गरेका छु/छौ । </p>');

$mpdf->WriteHTML('<table border="1" style="width: 100%; border-collapse: collapse;">');
$mpdf->WriteHTML('<tr>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">न. पा. /गा. पा.</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">वडा नं.</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">नक्सा नं.</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">कित्ता नं.</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">क्षेत्रफल</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">घर/बाटो भएको/नभएको</td>');
$mpdf->WriteHTML('</tr>');
$mpdf->WriteHTML('<tr>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">' . $wadaMemberHouseRoadMunicipality . '</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">' . $wadaMemberHouseRoadWard . '</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">' . $wadaMemberHouseRoadMapNo . '</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">' . $wadaMemberHouseRoadKittaNo . '</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">' . $wadaMemberHouseRoadArea . '</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">' . $wadaMemberHouseRoadRoadPresence . '</td>');
$mpdf->WriteHTML('</tr>');
$mpdf->WriteHTML('</table>');

$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;">निवेदक,</p>');
$mpdf->WriteHTML('<table width="100%" style="border: none;">');
$mpdf->WriteHTML('<tr>');
$mpdf->WriteHTML('<td width="50%" style="vertical-align: top;">');
$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;">जग्गा लिनेको सही,</p>');

if ($_SESSION['wadaMemberUserType'] == 2) {
    $signature = '<p style="text-align: left; font-size: 20px;"><img src="../../' . $wadaMemberDocumentTypeSignature . '" style="width: 100px; vertical-align: middle;" alt="Signature"></p>';
    $mpdf->WriteHTML($signature);
} else {
    $mpdf->WriteHTML('<br>');
    $mpdf->WriteHTML('<br>');
    $mpdf->WriteHTML('<br>');
}

$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;">ना. प्र. नं.: ' . $wadaMemberHouseRoadBuyerCitizenshipNo . ' (' . $wadaMemberHouseRoadBuyerCitizenshipDistrict . ')</p>');
$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;">मिति: ' . $nepaliDate . '</p>');
$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;">नाम/थर : ' . $wadaMemberHouseRoadHouseBuyerName . ' </p>');
$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;">ठेगाना : ' . $wadaMemberHouseRoadBuyerMunicipality . ', ' . $wadaMemberHouseRoadBuyerDistrict . ', ' . $wadaMemberHouseRoadBuyerProvince . ' प्रदेश</p>');
$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;">पति/पत्नीको नाम : ' . $wadaMemberHouseRoadBuyerSpouseName . '</p>');
$mpdf->WriteHTML('</td>');
$mpdf->WriteHTML('<td width="50%" style="vertical-align: top;">');
$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;">जग्गा धनीको सही,</p>');
$mpdf->WriteHTML('<br>');
$mpdf->WriteHTML('<br>');
$mpdf->WriteHTML('<br>');
$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;">ना. प्र. नं.: ' . $wadaMemberCitizenshipNumber . ' (' . $wadaMemberCitizenshipIssuedDistrict . ')</p>');
$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;">मिति: ' . $nepaliDate . '</p>');
$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;">नाम/थर : ' . $wadaMemberFirstNameNP . ' ' . $wadaMemberMiddleNameNP . ' ' . $wadaMemberLastNameNP . '</p>');
$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;">ठेगाना : ' . $wadaMemberPermanentMunicipality . ', ' . $wadaMemberPermanentDistrict . ', ' . $wadaMemberPermanentProvince . ' प्रदेश</p>');
$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;">पति/पत्नीको नाम : ' . $wadaMemberSpouseNameNP . '</p>');
$mpdf->WriteHTML('</td>');
$mpdf->WriteHTML('</tr>');
$mpdf->WriteHTML('</table>');

if ($_SESSION['wadaMemberUserType'] == 2) {
    $mpdf->AddPage();

    $mpdf->WriteHTML('<p style="text-align: center; font-size: 20px;">नागरिकता कागजात</p>');
    $applicant_citizenship = '<img src="../../' . $wadaMemberHouseRoadCitizenshipDocument . '" style="vertical-align: middle;" alt="Citizenship Of Applicant">';
    $mpdf->WriteHTML($applicant_citizenship);

    $mpdf->AddPage();
    $mpdf->WriteHTML('<p style="text-align: center; font-size: 20px;">जग्गाको स्वामित्वको कागजात</p>');
    $applicant_land_ownership = '<img src="../../' . $wadaMemberHouseRoadLandOwnershipDocument . '" style="vertical-align: middle;" alt="Land Ownership Document Of Applicant">';
    $mpdf->WriteHTML($applicant_land_ownership);

    $mpdf->AddPage();
    $mpdf->WriteHTML('<p style="text-align: center; font-size: 20px;">जग्गाको नक्सा</p>');
    $applicant_land_map = '<img src="../../' . $wadaMemberHouseRoadLandMapDocument . '" style="vertical-align: middle;" alt="Citizenship Of Applicant">';
    $mpdf->WriteHTML($applicant_land_map);

    $mpdf->AddPage();
    $mpdf->WriteHTML('<p style="text-align: center; font-size: 20px;">जग्गाको कर रसिद</p>');
    $applicant_land_tax = '<img src="../../' . $wadaMemberHouseRoadLandTaxDocument . '" style="vertical-align: middle;" alt="Citizenship Of Applicant">';
    $mpdf->WriteHTML($applicant_land_tax);
}

$houseRoadFileName = "House-Road-Verification" . $wadaMemberFirstNameNP . "_" . $wadaMemberLastNameNP . ".pdf";
$mpdf->Output($houseRoadFileName, 'I');

db_close($mysqli);