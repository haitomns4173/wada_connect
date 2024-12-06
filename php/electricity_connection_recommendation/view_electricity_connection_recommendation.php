<?php

require_once '../../php/database_connection.php';

$mysqli = db_connect();

function convertToNepali($string){
    $nepali = array("0"=>"०","1"=>"१","2"=>"२","3"=>"३","4"=>"४","5"=>"५","6"=>"६","7"=>"७","8"=>"८","9"=>"९");
    return strtr($string, $nepali);
}

if($mysqli){
    if(isset($_GET['wadaMemberElectricityFormID'])){
        $wadaMemberElectricityFormID = $_GET['wadaMemberElectricityFormID'];
        $stmt = $mysqli->prepare("SELECT * FROM `wadamemberelectricconnectiondata` WHERE wadaMemberElectricConnectionFormID = ?");
        $stmt->bind_param("i", $wadaMemberElectricityFormID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if($row){
            $wadaMemberElectricConnectionUserID = $row['wadaMemberElectricConnectionUserID'];
            $wadaMemberElectricConnectionDistrict = $row['wadaMemberElectricConnectionDistrict'];
            $wadaMemberElectricConnectionMunicipality = $row['wadaMemberElectricConnectionMunicipality'];
            $wadaMemberElectricConnectionWard = $row['wadaMemberElectricConnectionWard'];

            $wadaMemberElectricConnectionMapNo = $row['wadaMemberElectricConnectionMapNo'];
            $wadaMemberElectricConnectionKittaNo = $row['wadaMemberElectricConnectionKittaNo'];
            $wadaMemberElectricConnectionArea = $row['wadaMemberElectricConnectionArea'];

            $wadaMemberElectricConnectionCitizenshipDocument = $row['wadaMemberElectricConnectionCitizenshipDocument'];
            $wadaMemberElectricConnectionLandOwnershipDocument = $row['wadaMemberElectricConnectionLandOwnershipDocument'];
            $wadaMemberElectricConnectionLandMapDocument = $row['wadaMemberElectricConnectionLandMapDocument'];
            $wadaMemberElectricConnectionLandTaxDocument = $row['wadaMemberElectricConnectionLandTaxDocument'];

            $applicationType = 2;

            $stmt = $mysqli->prepare("SELECT `wadaConnectApplicationListingID`, `wadaConnectApplicationWadaSentStatus`, `wadaConnectApplicationStatus`, `wadaConnectApplicationApprovedDocument`, `wadaConnectApplicationRemarks` FROM `wadaconnectapplicationlisting` WHERE wadaConnectApplicationID = ? AND wadaConnectApplicationUserID = ? AND wadaConnectApplicationType = ?");
            $stmt->bind_param("iii", $wadaMemberElectricityFormID, $wadaMemberElectricConnectionUserID, $applicationType);
            $stmt->execute();
            $stmt->bind_result($wadaConnectApplicationListingID, $wadaConnectApplicationWadaSentStatus, $wadaConnectApplicationStatus, $wadaConnectApplicationApprovedDocument, $wadaConnectApplicationRemarks);
            $stmt->fetch();
        }else{
            echo "No data found";
        }

        $stmt->close();
    }else{
        echo "wadaMemberElectricityFormID is not set";
    }
}
else{
    echo "Database Connection Error";
}

db_close($mysqli);