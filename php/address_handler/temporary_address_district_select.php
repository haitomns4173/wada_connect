<?php
$mysqli = db_connect();

if ($mysqli) {
    $sql = "SELECT districtEnglishName FROM `wadaconnectdistrictnepal` INNER JOIN `wadaconnectprovincenepal` on provinceNepalID = provinceDistrictNepalID WHERE provinceEnglishName = '$wadaMemberTemperoryProvince';";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $wadaMemberTemperoryDistrict = ucfirst($wadaMemberTemperoryDistrict);
            if ($wadaMemberTemperoryDistrict == $row['districtEnglishName']) {
                echo "<option value='" . $row['districtEnglishName'] . "' selected>" . $row['districtEnglishName'] . "</option>";
            } else {
                echo "<option value='" . $row['districtEnglishName'] . "'>" . $row['districtEnglishName'] . "</option>";
            }
        }
    }
}

$mysqli->close();
?>