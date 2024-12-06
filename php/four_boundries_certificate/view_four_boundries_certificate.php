<?php

require_once '../../php/database_connection.php';

$mysqli = db_connect();

function convertToNepali($string){
    $nepali = array("0"=>"०","1"=>"१","2"=>"२","3"=>"३","4"=>"४","5"=>"५","6"=>"६","7"=>"७","8"=>"८","9"=>"९");
    return strtr($string, $nepali);
}

if($mysqli){
    if(isset($_GET['wadaMemberFourBoundariesFormID'])){
        $wadaMemberFourBoundariesFormID = $_GET['wadaMemberFourBoundariesFormID'];
        $stmt = $mysqli->prepare("SELECT * FROM `wadamemberfourboundariesdata` WHERE wadaMemberFourBoundariesFormID = ?");
        $stmt->bind_param("i", $wadaMemberFourBoundariesFormID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if($row){
            $wadaMemberFourBoundariesUserID = $row['wadaMemberFourBoundariesUserID'];
            $wadaMemberFourBoundariesDistrict = $row['wadaMemberFourBoundariesDistrict'];
            $wadaMemberFourBoundariesMunicipality = $row['wadaMemberFourBoundariesMunicipality'];
            $wadaMemberFourBoundariesKittaNo = $row['wadaMemberFourBoundariesKittaNo'];
            $wadaMemberFourBoundariesArea = $row['wadaMemberFourBoundariesArea'];

            $wadaMemberFourBoundariesEastPersonName = $row['wadaMemberFourBoundariesEastPersonName'];
            $wadaMemberFourBoundariesEast = convertToNepali($row['wadaMemberFourBoundariesEast']);
            $wadaMemberFourBoundariesWestPersonName = $row['wadaMemberFourBoundariesWestPersonName'];
            $wadaMemberFourBoundariesWest = convertToNepali($row['wadaMemberFourBoundariesWest']);
            $wadaMemberFourBoundariesNorthPersonName = $row['wadaMemberFourBoundariesNorthPersonName'];
            $wadaMemberFourBoundariesNorth = convertToNepali($row['wadaMemberFourBoundariesNorth']);
            $wadaMemberFourBoundariesSouthPersonName = $row['wadaMemberFourBoundariesSouthPersonName'];
            $wadaMemberFourBoundariesSouth = convertToNepali($row['wadaMemberFourBoundariesSouth']);

            $wadaMemberFourBoundariesCitizenshipDocument = $row['wadaMemberFourBoundariesCitizenshipDocument'];
            $wadaMemberFourBoundariesLandOwnershipDocument = $row['wadaMemberFourBoundariesLandOwnershipDocument'];
            $wadaMemberFourBoundariesLandMapDocument = $row['wadaMemberFourBoundariesLandMapDocument'];
            $wadaMemberFourBoundariesLandTaxDocument = $row['wadaMemberFourBoundariesLandTaxDocument'];

            $applicationType = 1;

            $stmt = $mysqli->prepare("SELECT `wadaConnectApplicationListingID`, `wadaConnectApplicationWadaSentStatus`, `wadaConnectApplicationStatus`, `wadaConnectApplicationApprovedDocument`, `wadaConnectApplicationRemarks` FROM `wadaconnectapplicationlisting` WHERE wadaConnectApplicationID = ? AND wadaConnectApplicationUserID = ? AND wadaConnectApplicationType = ?");
            $stmt->bind_param("iii", $wadaMemberFourBoundariesFormID, $wadaMemberFourBoundariesUserID, $applicationType);
            $stmt->execute();
            $stmt->bind_result($wadaConnectApplicationListingID, $wadaConnectApplicationWadaSentStatus, $wadaConnectApplicationStatus, $wadaConnectApplicationApprovedDocument, $wadaConnectApplicationRemarks);
            $stmt->fetch();
        }else{
            echo "No data found";
        }

        $stmt->close();
    }else{
        echo "wadaMemberFourBoundariesFormID is not set";
    }
}
else{
    echo "Database Connection Error";
}

db_close($mysqli);