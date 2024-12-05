<?php
    require_once 'database_connection.php';

    $mysqli = db_connect();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['wada_office_province']) && isset($_POST['wada_office_district']) && isset($_POST['wada_office_municipality']) && isset($_POST['wada_office_municipality_type']) && isset($_POST['wada_office_municipality_ward'])){
            if (is_numeric($_POST['wada_office_municipality_ward'])) {
                $wada_office_province = ucfirst($_POST['wada_office_province']);
                $wada_office_district = ucfirst($_POST['wada_office_district']);
                $wada_office_municipality = ucfirst($_POST['wada_office_municipality']);
                $wada_office_municipality_type = $_POST['wada_office_municipality_type'];
                $wada_office_municipality_ward = $_POST['wada_office_municipality_ward'];

                echo $wada_office_province . " " . $wada_office_district . " " . $wada_office_municipality . " " . $wada_office_municipality_type . " " . $wada_office_municipality_ward;

                $stmt = $mysqli->prepare("UPDATE `wadaconnectofficedetails` SET `wadaConnectOfficeProvince`=? ,`wadaConnnectOfficeDistrict`=?,`wadaConnnectOfficeMunicipality`=?,`wadaConnectOfficeMunicipalityType`=?,`wadaConnectOfficeWard`=? WHERE wadaConnnectOfficeID = 1");
                $stmt->bind_param("sssss", $wada_office_province, $wada_office_district, $wada_office_municipality, $wada_office_municipality_type, $wada_office_municipality_ward);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    echo "Account updated successfully!";
                    header("Location: ../wadaOffice/wada_office_account.php");
                }
                else {
                    echo "Account update failed!";
                }

                $stmt->close();
                db_close($mysqli);
            }
            else {
                echo "Ward must be a number.";
            }
        }
        else {
            echo "All fields are required.";
        }
    }
    else {
        echo "Error: Invalid request method.";
    }
?>