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

if (isset($_GET['wadaMemberRelationVerificationFormID']) && isset($_GET['wadaMemberID'])) {
    $wadaMemberRelationVerificationFormID = $_GET['wadaMemberRelationVerificationFormID'];
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

$mpdf->SetTitle('Relation Verification');
$mpdf->SetAuthor('Coders Inbox');
$mpdf->SetSubject('Relation Verification Letter');
$mpdf->SetKeywords('Relation Verification, Wada Member, Wada Connect, Wada Connect Application');

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

    $stmt = $mysqli->prepare("SELECT * FROM `wadamemberrelationdetails` WHERE wadaMemberRelationFormID = ?");
    if ($stmt) {
        $stmt->bind_param("i", $wadaMemberRelationVerificationFormID);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($wadaMemberRelationFormID, $wadaMemberRelationUserID, $wadaMemberRelationFullName, $wadaMemberRelationAge, $wadaMemberRelationGender, $wadaMemberRelationShip, $wadaMemberRelationDistrict, $wadaMemberRelationMunicipality, $wadaMemberRelationMunicipalityType, $wadaMemberRelationWard, $wadaMemberRelationCitizenshipDocument, $wadaMemberRelationSubmittedDateTime);
        $stmt->fetch();
    }

    $stmt = $mysqli->prepare("SELECT wadaMemberFirstNameNP, wadaMemberMiddleNameNP, wadaMemberLastNameNP, wadaMemberGender, wadaMemberPermanentMunicipality, wadaMemberPermanentDistrict, wadaMemberDocumentTypeSignature, wadaMemberDocumentTypeCitizenshipCard FROM wadamemberpersonaldetails INNER JOIN wadamemberaddressdetails ON wadaMemberID = wadaMemberAddressDetailsID INNER JOIN wadamembernepalidetails ON wadaMemberID = wadaMemberNepaliDetailsID INNER JOIN wadamembersdocumentdetails ON wadaMemberID = wadaMemberDocumentDetailsID WHERE wadaMemberID = ?");
    if ($stmt) {
        $stmt->bind_param("i", $wadaMemberRelationUserID);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($wadaMemberFirstNameNP, $wadaMemberMiddleNameNP, $wadaMemberLastNameNP, $wadaMemberGender, $wadaMemberPermanentMunicipality, $wadaMemberPermanentDistrict, $wadaMemberDocumentTypeSignature,  $wadaMemberDocumentTypeCitizenshipCard);
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

    $sql = "SELECT `districtNepaliName` FROM `wadaconnectdistrictnepal` WHERE districtEnglishName = '$wadaMemberRelationDistrict'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $wadaMemberRelationDistrict = $row['districtNepaliName'];

    $sql = "SELECT localLevelNepaliName FROM wadaconnectlocallevelnepal WHERE localLevelEnglishName = '$wadaMemberRelationMunicipality'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $wadaMemberRelationMunicipality = $row['localLevelNepaliName'];

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

$wadaMemberRelationAge = convertToNepaliNumber($wadaMemberRelationAge);
$wadaMemberRelationWard = convertToNepaliNumber($wadaMemberRelationWard);

if ($wadaMemberRelationGender == 'male') {
    $wadaMemberRelationGender = "पुरुष";
} else if ($wadaMemberRelationGender == 'female') {
    $wadaMemberRelationGender = "महिला";
} else {
    $wadaMemberRelationGender = "अन्य";
}

if ($wadaMemberGender == 'male') {
    $sentenceTag = "दिएको";
} else {
    $sentenceTag = "दिएकी";
}

$dateTimeParts = explode(' ', $wadaMemberRelationSubmittedDateTime);
$dateParts = explode('-', $dateTimeParts[0]);

$submittedYear = $dateParts[0];
$submittedMonth = $dateParts[1];
$submittedDay = $dateParts[2];

$nepaliDate = DateConverter::fromEnglishDate($submittedYear, $submittedMonth, $submittedDay)->toFormattedNepaliDate();

$nepaliDate = explode(',', $nepaliDate)[0];

$mpdf->WriteHTML('<h1 style="text-align: center; font-size: 25px;">अनुसूची ३०</h1>');
$mpdf->WriteHTML('<h1 style="text-align: center; font-size: 25px;">(नियम २७२ को उपनियम (१) सँग सम्बन्धित)</h1>');
$mpdf->WriteHTML('<p style="text-align: right; font-size: 20px;">मिति: ' . $nepaliDate . '</p>');
$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;">श्रीमान वडा प्रमुख ज्यु,</p>');
$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;"> ' . $wadaConnnectOfficeMunicipality . ' ' . $wadaConnectOfficeMunicipalityType . ' कार्यालय,</p>');
$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;"> ' . $wadaConnnectOfficeDistrict . ' जिल्ला ।</p>');

$mpdf->WriteHTML('<p style="text-align: center; font-size: 20px;">विषय: नाता प्रमाणित गरी पाउँ ।</p>');

$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;">महोदय, </p>');

$mpdf->WriteHTML('<p style="text-align: justify; font-size: 20px;">मेरो देहाय बमोजिमको व्यक्तिसँग देहाय बमोजिमको नाता सम्बन्ध कायम रहेकाले सो नाता सम्बन्ध प्रमाणित गरी पाउन नाता सम्बन्ध प्रमाणित दस्तुर यसै साथ संलग्न राखी यो दरखास्त ' . $sentenceTag . ' छु । नाता सम्बन्ध प्रमाणित गराउनको लागी म सँग भएको देहायका प्रमाण कागज यसै साथ संगजन राखेको छु।</p>');

$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;">नाता सम्बन्ध प्रमाणित गर्नु पर्ने व्यक्तिको विवरणहरु,</p>');

$mpdf->WriteHTML('<table border="1" style="width: 100%; border-collapse: collapse;">');
$mpdf->WriteHTML('<tr>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">क्र. स.</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">नाम, थर</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">उमेर</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">लिङ्ग</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">ठेगाना</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">कायम रहेको नाता/सम्बन्ध</td>');
$mpdf->WriteHTML('</tr>');
$mpdf->WriteHTML('<tr>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">१</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">' . $wadaMemberRelationFullName . '</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">' . $wadaMemberRelationAge . '</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">' . $wadaMemberRelationGender . '</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">' . $wadaMemberRelationDistrict . ', ' . $wadaMemberRelationMunicipality . '-' . $wadaMemberRelationWard . '</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">' . $wadaMemberRelationShip . '</td>');
$mpdf->WriteHTML('</tr>');
$mpdf->WriteHTML('</table>');

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

    $mpdf->WriteHTML('<p style="text-align: center; font-size: 20px;">आवेदक नागरिकता</p>');
    $applicant_citizenship = '<img src="../../' . $wadaMemberDocumentTypeCitizenshipCard . '" style="vertical-align: middle;" alt="Citizenship Of Applicant">';
    $mpdf->WriteHTML($applicant_citizenship);
    
    $mpdf->AddPage();
    $mpdf->WriteHTML('<p style="text-align: center; font-size: 20px;">सम्बन्धित व्यक्तिको नागरिकता कार्ड</p>');
    $applicant_citizenship = '<img src="../../' . $wadaMemberRelationCitizenshipDocument . '" style="vertical-align: middle;" alt="Citizenship Of Applicant">';
    $mpdf->WriteHTML($applicant_citizenship);
}


$relationVerificationFileName = "Relation_Verification_Certificate_" . $wadaMemberFirstNameNP . "_" . $wadaMemberLastNameNP . ".pdf";
$mpdf->Output($relationVerificationFileName, 'I');

db_close($mysqli);
