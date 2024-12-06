<?php
$mysqli = db_connect();

if ($mysqli) {
    $sql = "SELECT `provinceEnglishName` FROM `wadaconnectprovincenepal`;";
    $result = $mysqli->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $wadaMemberTemperoryProvince = ucfirst($wadaMemberTemperoryProvince);
            if ($wadaMemberTemperoryProvince == $row['provinceEnglishName']) {
                echo "<option value='" . $row['provinceEnglishName'] . "' selected>" . $row['provinceEnglishName'] . " Pradesh</option>";
            } else {
                echo "<option value='" . $row['provinceEnglishName'] . "'>" . $row['provinceEnglishName'] . " Pradesh</option>";
            }
        }
    }
}

$mysqli->close();
?>