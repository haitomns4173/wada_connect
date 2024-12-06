<?php

$mysqli = db_connect();

if($mysqli){
    $sql = "SELECT `localLevelEnglishName` FROM `wadaconnectlocallevelnepal` INNER JOIN `wadaconnectdistrictnepal` ON districtNepalID = localLevelDistrictID WHERE districtEnglishName = '$wadaMemberTemperoryDistrict'";
    $result = $mysqli->query($sql);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $wadaMemberTemperoryMunicipality = ucfirst($wadaMemberTemperoryMunicipality);
            if($wadaMemberTemperoryMunicipality == $row['localLevelEnglishName']){
                echo "<option value='" . $row['localLevelEnglishName'] . "' selected>" . $row['localLevelEnglishName'] . "</option>";
            }else{
                echo "<option value='" . $row['localLevelEnglishName'] . "'>" . $row['localLevelEnglishName'] . "</option>";
            }
        }
    }
}

$mysqli->close();
?>