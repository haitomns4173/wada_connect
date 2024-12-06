<?php

$mysqli = db_connect();

if($mysqli){
    $sql = "SELECT `localLevelEnglishName` FROM `wadaconnectlocallevelnepal` INNER JOIN `wadaconnectdistrictnepal` ON districtNepalID = localLevelDistrictID WHERE districtEnglishName = '$wadaMemberPermanentDistrict'";
    $result = $mysqli->query($sql);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $wadaMemberPermanentMunicipality = ucfirst($wadaMemberPermanentMunicipality);
            if($wadaMemberPermanentMunicipality == $row['localLevelEnglishName']){
                echo "<option value='" . $row['localLevelEnglishName'] . "' selected>" . $row['localLevelEnglishName'] . "</option>";
            }else{
                echo "<option value='" . $row['localLevelEnglishName'] . "'>" . $row['localLevelEnglishName'] . "</option>";
            }
        }
    }
}

$mysqli->close();
?>