<?php
require_once '../database_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['electricity-connection-district-column']) && isset($_POST['electricity-connection-municipality-column']) && isset($_POST['electricity-connection-municipality-type-column']) && isset($_POST['electricity-connection-map-column']) && isset($_POST['electricity-connection-ward-column']) && isset($_POST['electricity-connection-kitta-number-column']) && isset($_POST['electricity-connection-area-column'])) {
        session_start();

        if (isset($_SESSION['electricity_connection_form_data']) && count($_SESSION['electricity_connection_form_data']) > 0) {
            echo "<script>alert('One data per from is allowed.'); window.location.href = '../../wadaUsers/wadaUsersApplication/electricity_connection_recommendation.php';</script>";
            exit();
        }

        $main_folder = '../../wadaMemberDocuments/';
        $session_folder = $main_folder . 'session/';

        if (!file_exists($session_folder)) {
            mkdir($session_folder, 0755, true);
        }

        $maxFileSize = 500 * 1024;

        function generateFileName($fileName, $type, $district_municipality_name)
        {
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $baseFileName = "{$district_municipality_name}_{$type}_" . uniqid();
            return "{$baseFileName}.{$fileExtension}";
        }

        function uploadFile($file, $folder, $maxFileSize, $type, $district_municipality_name)
        {
            $validImageTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            $fileMimeType = mime_content_type($file['tmp_name']);
        
            if (!in_array($fileMimeType, $validImageTypes)) {
                echo "Only JPG, PNG, and GIF image files are allowed.";
                return false;
            }

            if ($file['size'] > $maxFileSize) {
                echo "File size exceeds the limit of 500 KB.";
                return false;
            }

            $uniqueFileName = generateFileName($file["name"], $type, $district_municipality_name);
            $target_file = $folder . $uniqueFileName;

            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                return $target_file;
            } else {
                return false;
            }
        }

        $district_municipality_name = $_POST['electricity-connection-district-column'] . '_' . $_POST['electricity-connection-municipality-column'];        

        if(isset($_FILES['electricity-connection-citizenship-column'])){
            $citizenship_document = uploadFile($_FILES['electricity-connection-citizenship-column'], $session_folder, $maxFileSize, 'citizenship', $district_municipality_name);
        } else {
            echo "Citizenship document is required.";
        }

        if(isset($_FILES['electricity-connection-land-ownership-column'])){
            $land_ownership_document = uploadFile($_FILES['electricity-connection-land-ownership-column'], $session_folder, $maxFileSize, 'land_ownership', $district_municipality_name);
        } else {
            echo "Land ownership document is required.";
        }

        if(isset($_FILES['electricity-connection-land-map-column'])){
            $land_map_document = uploadFile($_FILES['electricity-connection-land-map-column'], $session_folder, $maxFileSize, 'land_map', $district_municipality_name);
        } else {
            echo "Land map document is required.";
        }

        if(isset($_FILES['electricity-connection-land-tax-column'])){
            $land_tax_document = uploadFile($_FILES['electricity-connection-land-tax-column'], $session_folder, $maxFileSize, 'land_tax', $district_municipality_name);
        } else {
            echo "Land tax document is required.";
        }

        if (!isset($_SESSION['electricity_connection_form_data'])) {
            $_SESSION['electricity_connection_form_data'] = array();
        }

        $citizenship_document = str_replace("../../wadaMemberDocuments/session/", "", $citizenship_document);
        $land_ownership_document = str_replace("../../wadaMemberDocuments/session/", "", $land_ownership_document);
        $land_map_document = str_replace("../../wadaMemberDocuments/session/", "", $land_map_document);
        $land_tax_document = str_replace("../../wadaMemberDocuments/session/", "", $land_tax_document);

        $electricity_connection_form_data_id = count($_SESSION['electricity_connection_form_data']) + 1;
        $electricity_connection_form_values_array = array(
            'electricity_connection_form_data_id' => $electricity_connection_form_data_id,
            'electricity-connection-district' => $_POST['electricity-connection-district-column'],
            'electricity-connection-municipality' => $_POST['electricity-connection-municipality-column'],
            'electricity-connection-municipality-type' => $_POST['electricity-connection-municipality-type-column'],
            'electricity-connection-map' => $_POST['electricity-connection-map-column'],
            'electricity-connection-ward' => $_POST['electricity-connection-ward-column'],
            'electricity-connection-kitta-number' => $_POST['electricity-connection-kitta-number-column'],
            'electricity-connection-area' => $_POST['electricity-connection-area-column'],
            'electricity-connection-citizenship-document' => $citizenship_document,
            'electricity-connection-land-ownership-document' => $land_ownership_document,
            'electricity-connection-land-map-document' => $land_map_document,
            'electricity-connection-land-tax-document' => $land_tax_document
        );

        $_SESSION['electricity_connection_form_data'][] = $electricity_connection_form_values_array;

        header("Location: ../../wadaUsers/wadaUsersApplication/electricity_connection_recommendation.php");
    } else {
        echo "District, Municipality, Ward, Map No., Kitta No. and Area columns are required.";
    }
} else {
    echo "Invalid request method. Please use POST.";
}
