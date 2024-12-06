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

if(isset($_GET['wadaMemberFourBoundariesFormID']) && $_GET['wadaMemberID']){
    $wadaMemberFourBoundariesFormID = $_GET['wadaMemberFourBoundariesFormID'];
    $wadaMemberID = $_GET['wadaMemberID'];
}
else{
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

$mpdf->SetTitle('Four Boundaries Certificate');
$mpdf->SetAuthor('Coders Inbox');
$mpdf->SetSubject('Certificate for Four Boundaries');
$mpdf->SetKeywords('Four Boundaries, Certificate, PDF');

function convertToNepaliNumber($englishNumber) {
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

    $stmt = $mysqli->prepare("SELECT * FROM wadamemberfourboundariesdata WHERE wadaMemberFourBoundariesFormID = ?");
    if ($stmt) {
        $stmt->bind_param("i", $wadaMemberFourBoundariesFormID);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($wadaMemberFourBoundariesFormID, $wadaMemberFourBoundariesUserID, $wadaMemberFourBoundariesDistrict, $wadaMemberFourBoundariesMunicipality, $wadaMemberFourBoundariesMunicipalityType, $wadaMemberFourBoundariesWard, $wadaMemberFourBoundariesKittaNo, $wadaMemberFourBoundariesArea, $wadaMemberFourBoundariesEastPersonName, $wadaMemberFourBoundariesEast, $wadaMemberFourBoundariesWestPersonName, $wadaMemberFourBoundariesWest, $wadaMemberFourBoundariesNorthPersonName, $wadaMemberFourBoundariesNorth, $wadaMemberFourBoundariesSouthPersonName, $wadaMemberFourBoundariesSouth, $wadaMemberFourBoundariesCitizenshipDocument, $wadaMemberFourBoundariesLandOwnershipDocument, $wadaMemberFourBoundariesLandMapDocument, $wadaMemberFourBoundariesLandTaxDocument ,$wadaMemberFourBoundariesSubmittedDateTime);
        $stmt->fetch();
    }

    $stmt = $mysqli->prepare("SELECT wadaMemberFirstNameNP, wadaMemberMiddleNameNP, wadaMemberLastNameNP, wadaMemberPermanentMunicipality, wadaMemberPermanentDistrict, wadaMemberDocumentTypeSignature FROM wadamemberpersonaldetails INNER JOIN wadamemberaddressdetails ON wadaMemberID = wadaMemberAddressDetailsID INNER JOIN wadamembernepalidetails ON wadaMemberID = wadaMemberNepaliDetailsID INNER JOIN wadamembersdocumentdetails ON wadaMemberID = wadaMemberDocumentDetailsID WHERE wadaMemberID = ?");
    if ($stmt) {
        $stmt->bind_param("i", $wadaMemberFourBoundariesUserID);
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

    $sql = "SELECT `districtNepaliName` FROM `wadaconnectdistrictnepal` WHERE districtEnglishName = '$wadaMemberFourBoundariesDistrict'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $wadaMemberFourBoundariesDistrict = $row['districtNepaliName'];

    $sql = "SELECT localLevelNepaliName FROM wadaconnectlocallevelnepal WHERE localLevelEnglishName = '$wadaMemberFourBoundariesMunicipality'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $wadaMemberFourBoundariesMunicipality = $row['localLevelNepaliName'];

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

if($wadaConnectOfficeMunicipalityType == "Metropolitan"){
    $wadaConnectOfficeMunicipalityType = "महानगरपालिका";
}
else if($wadaConnectOfficeMunicipalityType == "Sub-Metropolitan"){
    $wadaConnectOfficeMunicipalityType = "उप-महानगरपालिका";
}
else if($wadaConnectOfficeMunicipalityType == "Municipality"){
    $wadaConnectOfficeMunicipalityType = "नगरपालिका";
}

if($wadaMemberFourBoundariesMunicipalityType == "Metropolitan"){
    $wadaMemberFourBoundariesMunicipalityType = "महानगरपालिका";
}
else if($wadaMemberFourBoundariesMunicipalityType == "Sub-Metropolitan"){
    $wadaMemberFourBoundariesMunicipalityType = "उप-महानगरपालिका";
}
else if($wadaMemberFourBoundariesMunicipalityType == "Municipality"){
    $wadaMemberFourBoundariesMunicipalityType = "नगरपालिका";
}

$dateTimeParts = explode(' ', $wadaMemberFourBoundariesSubmittedDateTime);
$dateParts = explode('-', $dateTimeParts[0]);

$submittedYear = $dateParts[0];
$submittedMonth = $dateParts[1];
$submittedDay = $dateParts[2];

$nepaliDate = DateConverter::fromEnglishDate($submittedYear, $submittedMonth, $submittedDay)->toFormattedNepaliDate();

$nepaliDate = explode(',', $nepaliDate)[0];

$wadaMemberFourBoundariesWard = convertToNepaliNumber($wadaMemberFourBoundariesWard);
$wadaMemberFourBoundariesKittaNo = convertToNepaliNumber($wadaMemberFourBoundariesKittaNo);
$wadaMemberFourBoundariesArea = convertToNepaliNumber($wadaMemberFourBoundariesArea);

$wadaMemberFourBoundariesEast = convertToNepaliNumber($wadaMemberFourBoundariesEast);
$wadaMemberFourBoundariesWest = convertToNepaliNumber($wadaMemberFourBoundariesWest);
$wadaMemberFourBoundariesNorth = convertToNepaliNumber($wadaMemberFourBoundariesNorth);
$wadaMemberFourBoundariesSouth = convertToNepaliNumber($wadaMemberFourBoundariesSouth);

$mpdf->WriteHTML('<p style="text-align: right; font-size: 20px;">मिति: '.$nepaliDate.'</p>');
$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;">श्रीमान वडा प्रमुख ज्यु,</p>');
$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;"> '.$wadaConnnectOfficeMunicipality.' '.$wadaConnectOfficeMunicipalityType.' कार्यालय,</p>');
$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;"> '.$wadaConnnectOfficeDistrict.' जिल्ला ।</p>');

$mpdf->WriteHTML('<p style="text-align: center; font-size: 20px;">विषय: चार किल्ला प्रमणित गरी पाउँ ।</p>');

$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;">महोदय, </p>');

$mpdf->WriteHTML('<p style="text-align: justify; font-size: 20px;"> उपर्युक्त सम्बन्धमा '.$wadaMemberFourBoundariesMunicipality.' '.$wadaMemberFourBoundariesMunicipalityType.' वडा नं. '.$wadaMemberFourBoundariesWard.' को मेरो नाम मा दर्ता भएको जिल्ला '.$wadaMemberFourBoundariesDistrict.' साबिक हाल '.$wadaMemberFourBoundariesMunicipality.' '.$wadaMemberFourBoundariesMunicipalityType.' वडा नं. '.$wadaMemberFourBoundariesWard.' मा पर्ने किता नं. '.$wadaMemberFourBoundariesKittaNo.' छेत्रफल '.$wadaMemberFourBoundariesArea.' भएको जग्गा को चार किल्लामा तपसील बामोजिमको सँधियारहरु/विवरणहरु भएको चार किल्ला प्रमाणितको लागि लगने सुल्क को नगद रसिद सहित सो निवेदन पेश गरेको छु। व्यहोरा साचो छ, झुटो ठहरे कानुन बमोजिम सजाय सहुँला बुझाउँला ।</p>');

$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;">तपसील बमोजिनको सँधियारहरु/विवरणहरु, </p>');

$mpdf->WriteHTML('<table border="1" style="width: 100%; border-collapse: collapse;">');
$mpdf->WriteHTML('<tr>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">क्र. स.</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">जिल्ला</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">न. पा. /गा. पा.</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">वडा नं.</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">कित्ता नं.</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">क्षेत्रफल</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">चार किल्ला</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">कैफियत</td>');
$mpdf->WriteHTML('</tr>');
$mpdf->WriteHTML('<tr>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">१</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">'.$wadaMemberFourBoundariesDistrict.'</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">'.$wadaMemberFourBoundariesMunicipality.'</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">'.$wadaMemberFourBoundariesWard.'</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">'.$wadaMemberFourBoundariesKittaNo.'</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;">'.$wadaMemberFourBoundariesArea.'</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;"> 
<ul>
    <li>पूर्व: '.$wadaMemberFourBoundariesEastPersonName.' ('.$wadaMemberFourBoundariesEast.')</li>
    <li>पश्चिम: '.$wadaMemberFourBoundariesWestPersonName.' ('.$wadaMemberFourBoundariesWest.')</li>
    <li>उत्तर: '.$wadaMemberFourBoundariesNorthPersonName.' ('.$wadaMemberFourBoundariesNorth.')</li>
    <li>दक्षिण: '.$wadaMemberFourBoundariesSouthPersonName.' ('.$wadaMemberFourBoundariesSouth.')</li>
</ul>
</td>');
$mpdf->WriteHTML('<td style="text-align: center; font-size: 20px;"></td>');
$mpdf->WriteHTML('</tr>');
$mpdf->WriteHTML('</table>');

$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;">निवेदक,</p>');
$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;">सही : </p>');

if ($_SESSION['wadaMemberUserType'] == 2) {
    $signature = '<p style="text-align: left; font-size: 20px;"><img src="../../' . $wadaMemberDocumentTypeSignature . '" style="width: 100px; vertical-align: middle;" alt="Signature"></p>';
    $mpdf->WriteHTML($signature);
}

$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;">नाम: '.$wadaMemberFirstNameNP.' '.$wadaMemberMiddleNameNP.' '.$wadaMemberLastNameNP.'</p>');
$mpdf->WriteHTML('<p style="text-align: left; font-size: 20px;">ठेगाना: '.$wadaMemberPermanentMunicipality.', '.$wadaMemberPermanentDistrict.'</p>');

if ($_SESSION['wadaMemberUserType'] == 2) {
    $mpdf->AddPage();

    $mpdf->WriteHTML('<p style="text-align: center; font-size: 20px;">नागरिकता कागजात</p>');
    $applicant_citizenship = '<img src="../../' . $wadaMemberFourBoundariesCitizenshipDocument . '" style="vertical-align: middle;" alt="Citizenship Of Applicant">';
    $mpdf->WriteHTML($applicant_citizenship);

    $mpdf->AddPage();
    $mpdf->WriteHTML('<p style="text-align: center; font-size: 20px;">जग्गाको स्वामित्वको कागजात</p>');
    $applicant_land_ownership = '<img src="../../' . $wadaMemberFourBoundariesLandOwnershipDocument . '" style="vertical-align: middle;" alt="Land Ownership Document Of Applicant">';
    $mpdf->WriteHTML($applicant_land_ownership);

    $mpdf->AddPage();
    $mpdf->WriteHTML('<p style="text-align: center; font-size: 20px;">जग्गाको नक्सा</p>');
    $applicant_land_map = '<img src="../../' . $wadaMemberFourBoundariesLandMapDocument . '" style="vertical-align: middle;" alt="Citizenship Of Applicant">';
    $mpdf->WriteHTML($applicant_land_map);

    $mpdf->AddPage();
    $mpdf->WriteHTML('<p style="text-align: center; font-size: 20px;">जग्गाको कर रसिद</p>');
    $applicant_land_tax = '<img src="../../' . $wadaMemberFourBoundariesLandTaxDocument . '" style="vertical-align: middle;" alt="Citizenship Of Applicant">';
    $mpdf->WriteHTML($applicant_land_tax);
}

$fourBoundriesFileName = "Four_Boundaries_Certificate_" . $wadaMemberFirstNameNP . "_" . $wadaMemberLastNameNP . ".pdf";
$mpdf->Output($fourBoundriesFileName, 'I');

db_close($mysqli);
?>