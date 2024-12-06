<?php

require_once '../../php/database_connection.php';

$mysqli = db_connect();

function convertToNepali($string){
    $nepali = array("0"=>"०","1"=>"१","2"=>"२","3"=>"३","4"=>"४","5"=>"५","6"=>"६","7"=>"७","8"=>"८","9"=>"९");
    return strtr($string, $nepali);
}

if($mysqli){
    if(isset($_GET['wadaMemberRelationFormID'])){
        $wadaMemberRelationFormID = $_GET['wadaMemberRelationFormID'];
        $stmt = $mysqli->prepare("SELECT * FROM `wadamemberrelationdetails` WHERE wadaMemberRelationFormID = ?");
        $stmt->bind_param("i", $wadaMemberRelationFormID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if($row){
            $wadaMemberRelationUserID = $row['wadaMemberRelationUserID'];
            $wadaMemberRelationFullName = $row['wadaMemberRelationFullName'];
            $wadaMemberRelationAge = convertToNepali($row['wadaMemberRelationAge']);

            if($row['wadaMemberRelationGender'] == 'male'){
                $wadaMemberRelationGender = "पुरुष";
            }
            else if($row['wadaMemberRelationGender'] == 'female'){
                $wadaMemberRelationGender = "महिला";
            }
            else{
                $wadaMemberRelationGender = "अन्य";
            }
            
            $wadaMemberRelationRelation = $row['wadaMemberRelationShip'];
            $wadaMemberRelationDistrict = $row['wadaMemberRelationDistrict'];
            $wadaMemberRelationMunicipality = $row['wadaMemberRelationMunicipality'];
            $wadaMemberRelationMunicipalityType = $row['wadaMemberRelationMunicipalityType'];
            $wadaMemberRelationWard = $row['wadaMemberRelationWard'];
            $wadaMemberRelationCitizenshipDocument = $row['wadaMemberRelationCitizenshipDocument'];

            $applicationType = 3;

            $stmt = $mysqli->prepare("SELECT `wadaConnectApplicationListingID`, `wadaConnectApplicationWadaSentStatus`, `wadaConnectApplicationStatus`, `wadaConnectApplicationApprovedDocument`, `wadaConnectApplicationRemarks` FROM `wadaconnectapplicationlisting` WHERE wadaConnectApplicationID = ? AND wadaConnectApplicationUserID = ? AND wadaConnectApplicationType = ?");
            $stmt->bind_param("iii", $wadaMemberRelationFormID, $wadaMemberRelationUserID, $applicationType);
            $stmt->execute();
            $stmt->bind_result($wadaConnectApplicationListingID, $wadaConnectApplicationWadaSentStatus, $wadaConnectApplicationStatus, $wadaConnectApplicationApprovedDocument, $wadaConnectApplicationRemarks);
            $stmt->fetch();
        }else{
            echo "No data found";
        }

        $stmt->close();
    }else{
        echo "wadaMemberRelationFormID is not set";
    }
}
else{
    echo "Database Connection Error";
}

db_close($mysqli);