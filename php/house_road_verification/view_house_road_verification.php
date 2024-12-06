<?php

require_once '../../php/database_connection.php';

$mysqli = db_connect();

function convertToNepali($string){
    $nepali = array("0"=>"०","1"=>"१","2"=>"२","3"=>"३","4"=>"४","5"=>"५","6"=>"६","7"=>"७","8"=>"८","9"=>"९");
    return strtr($string, $nepali);
}

if($mysqli){
    if(isset($_GET['wadaMemberHouseRoadFormID'])){
        $wadaMemberHouseRoadFormID = $_GET['wadaMemberHouseRoadFormID'];
        $stmt = $mysqli->prepare("SELECT * FROM `wadamemberhouseroaddetails` WHERE wadaMemberHouseRoadFormID = ?");
        $stmt->bind_param("i", $wadaMemberHouseRoadFormID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if($row){
            $wadaMemberHouseRoadUserID = $row['wadaMemberHouseRoadUserID'];
            $wadaMemberHouseRoadMapNo = $row['wadaMemberHouseRoadMapNo'];
            $wadaMemberHouseRoadKittaNo = $row['wadaMemberHouseRoadKittaNo'];
            $wadaMemberHouseRoadArea = $row['wadaMemberHouseRoadArea'];
            $wadaMemberHouseRoadRoadPresence = $row['wadaMemberHouseRoadRoadPresence'];

            $wadaMemberHouseRoadHouseBuyerName = $row['wadaMemberHouseRoadHouseBuyerName'];

            $wadaMemberHouseRoadBuyerDistrict = $row['wadaMemberHouseRoadBuyerDistrict'];
            $stmt = $mysqli->prepare("SELECT `districtNepaliName` FROM `wadaconnectdistrictnepal` WHERE districtEnglishName = ?;");
            $stmt->bind_param("s", $wadaMemberHouseRoadBuyerDistrict);
            $stmt->execute();
            $stmt->bind_result($districtNepaliName);
            $stmt->fetch();
            $stmt->close();

            $wadaMemberHouseRoadBuyerDistrict = $districtNepaliName;

            $wadaMemberHouseRoadBuyerMunicipality = $row['wadaMemberHouseRoadBuyerMunicipality'];
            $stmt = $mysqli->prepare("SELECT `localLevelNepaliName` FROM `wadaconnectlocallevelnepal` WHERE localLevelEnglishName = ?;");
            $stmt->bind_param("s", $wadaMemberHouseRoadBuyerMunicipality);
            $stmt->execute();
            $stmt->bind_result($municipalityEnglishName);
            $stmt->fetch();
            $stmt->close();

            $wadaMemberHouseRoadBuyerMunicipality = $municipalityEnglishName;

            $wadaMemberHouseRoadBuyerWard = convertToNepali($row['wadaMemberHouseRoadBuyerWard']);

            $wadaMemberHouseRoadCitizenshipDocument = $row['wadaMemberHouseRoadCitizenshipDocument'];
            $wadaMemberHouseRoadLandOwnershipDocument = $row['wadaMemberHouseRoadLandOwnershipDocument'];
            $wadaMemberHouseRoadLandMapDocument = $row['wadaMemberHouseRoadLandMapDocument'];
            $wadaMemberHouseRoadLandTaxDocument = $row['wadaMemberHouseRoadLandTaxDocument'];

            $applicationType = 4;

            $stmt = $mysqli->prepare("SELECT `wadaConnectApplicationListingID`, `wadaConnectApplicationWadaSentStatus`, `wadaConnectApplicationStatus`, `wadaConnectApplicationApprovedDocument`, `wadaConnectApplicationRemarks` FROM `wadaconnectapplicationlisting` WHERE wadaConnectApplicationID = ? AND wadaConnectApplicationUserID = ? AND wadaConnectApplicationType = ?");
            $stmt->bind_param("iii", $wadaMemberHouseRoadFormID, $wadaMemberHouseRoadUserID, $applicationType);
            $stmt->execute();
            $stmt->bind_result($wadaConnectApplicationListingID, $wadaConnectApplicationWadaSentStatus, $wadaConnectApplicationStatus, $wadaConnectApplicationApprovedDocument, $wadaConnectApplicationRemarks);
            $stmt->fetch();
            $stmt->close();
        }else{
            echo "No data found";
        }
    }else{
        echo "wadaMemberHouseRoadFormID is not set";
    }
}
else{
    echo "Database Connection Error";
}

db_close($mysqli);