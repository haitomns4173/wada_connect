<?php

$mysqli = db_connect();

if ($mysqli) {
    $sql = "SELECT districtEnglishName FROM wadaconnectdistrictnepal;";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($wadaMemberCitizenshipIssuedDistrict == $row['districtEnglishName']) {
                echo "<option value='" . $row['districtEnglishName'] . "' selected>" . $row['districtEnglishName'] . "</option>";
            } else {
                echo "<option value='" . $row['districtEnglishName'] . "'>" . $row['districtEnglishName'] . "</option>";
            }
        }
    }
}
