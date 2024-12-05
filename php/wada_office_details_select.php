<?php
    require_once 'database_connection.php';

    $mysqli = db_connect();

    if ($mysqli) {
        $stmt = $mysqli->prepare("SELECT `wadaConnectOfficeProvince`, `wadaConnnectOfficeDistrict`, `wadaConnnectOfficeMunicipality`, `wadaConnectOfficeMunicipalityType`, `wadaConnectOfficeWard` FROM `wadaconnectofficedetails` WHERE wadaConnnectOfficeID = 1;");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($wadaConnectOfficeProvince, $wadaConnnectOfficeDistrict, $wadaConnnectOfficeMunicipality, $wadaConnectOfficeMunicipalityType, $wadaConnectOfficeWard);
        $stmt->fetch();

        $stmt->close();
    }
    
    db_close($mysqli);
?>