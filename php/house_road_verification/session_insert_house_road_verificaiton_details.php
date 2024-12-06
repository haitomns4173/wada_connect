<?php
require_once '../database_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['house-road-verification-district-column']) && isset($_POST['house-road-verification-municipality-column']) && isset($_POST['house-road-verification-municipality-type-column']) && isset($_POST['house-road-verification-ward-column']) && isset($_POST['house-road-verification-map-column']) && isset($_POST['house-road-verification-kitta-number-column']) && isset($_POST['house-road-verification-area-column']) && isset($_POST['house-road-verification-road-presence-column']) && isset($_POST['house-road-verification-land-buyer-name-column']) && isset($_POST['house-road-verification-land-buyer-citizenship-number-column']) && isset($_POST['house-road-verification-land-buyer-citizenship-district-column']) && isset($_POST['house-road-verification-land-buyer-province-column']) && isset($_POST['house-road-verification-land-buyer-district-column']) && isset($_POST['house-road-verification-land-buyer-municipality-column']) && isset($_POST['house-road-verification-land-buyer-ward-column'])) {
        session_start();

        if (isset($_SESSION['house_road_verification_form_data']) && count($_SESSION['house_road_verification_form_data']) > 0) {
            echo "<script>alert('One data per from is allowed.'); window.location.href = '../../wadaUsers/wadaUsersApplication/house_road_verification.php';</script>";
            exit();
        }

        $main_folder = '../../wadaMemberDocuments/';
        $session_folder = $main_folder . 'session/';

        if (!file_exists($session_folder)) {
            mkdir($session_folder, 0755, true);
        }

        $maxFileSize = 500 * 1024;

        function generateFileName($fileName, $type, $district_municipality_buyer_name)
        {
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $baseFileName = "{$district_municipality_buyer_name}_{$type}_" . uniqid();
            return "{$baseFileName}.{$fileExtension}";
        }

        function uploadFile($file, $folder, $maxFileSize, $type, $district_municipality_buyer_name)
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

            $uniqueFileName = generateFileName($file["name"], $type, $district_municipality_buyer_name);
            $target_file = $folder . $uniqueFileName;

            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                return $target_file;
            } else {
                return false;
            }
        }

        $district_municipality_buyer_name = $_POST['house-road-verification-district-column'] . '_' . $_POST['house-road-verification-municipality-column'] . '_' . $_POST['house-road-verification-land-buyer-name-column'];

        if(isset($_FILES['house-road-verification-citizenship-column'])){
            $citizenship_document = uploadFile($_FILES['house-road-verification-citizenship-column'], $session_folder, $maxFileSize, 'citizenship', $district_municipality_buyer_name);
        } else {
            echo "Citizenship document is required.";
        }

        if(isset($_FILES['house-road-verification-land-ownership-column'])){
            $land_ownership_document = uploadFile($_FILES['house-road-verification-land-ownership-column'], $session_folder, $maxFileSize, 'land_ownership', $district_municipality_buyer_name);
        } else {
            echo "Land ownership document is required.";
        }

        if(isset($_FILES['house-road-verification-land-map-column'])){
            $land_map_document = uploadFile($_FILES['house-road-verification-land-map-column'], $session_folder, $maxFileSize, 'land_map', $district_municipality_buyer_name);
        } else {
            echo "Land map document is required.";
        }

        if(isset($_FILES['house-road-verification-land-tax-column'])){
            $land_tax_document = uploadFile($_FILES['house-road-verification-land-tax-column'], $session_folder, $maxFileSize, 'land_tax', $district_municipality_buyer_name);
        } else {
            echo "Land Tax document is required.";
        }
        
        if (!isset($_SESSION['house_road_verification_form_data'])) {
            $_SESSION['house_road_verification_form_data'] = array();
        }

        $citizenship_document = str_replace("../../wadaMemberDocuments/session/", "", $citizenship_document);
        $land_ownership_document = str_replace("../../wadaMemberDocuments/session/", "", $land_ownership_document);
        $land_map_document = str_replace("../../wadaMemberDocuments/session/", "", $land_map_document);
        $land_tax_document = str_replace("../../wadaMemberDocuments/session/", "", $land_tax_document);

        $house_road_verification_form_data_id = count($_SESSION['house_road_verification_form_data']) + 1;
        $house_road_verification_form_data_array = array(
            'house_road_data_id' => $house_road_verification_form_data_id,
            'house_road_verification_district_column' => $_POST['house-road-verification-district-column'],
            'house_road_verification_municipality_column' => $_POST['house-road-verification-municipality-column'],
            'house_road_verification_municipality_type_column' => $_POST['house-road-verification-municipality-type-column'],
            'house_road_verification_ward_column' => $_POST['house-road-verification-ward-column'],
            'house_road_verification_map_column' => $_POST['house-road-verification-map-column'],
            'house_road_verification_kitta_number_column' => $_POST['house-road-verification-kitta-number-column'],
            'house_road_verification_area_column' => $_POST['house-road-verification-area-column'],
            'house_road_verification_road_presence_column' => $_POST['house-road-verification-road-presence-column'],
            'house_road_verification_land_buyer_name_column' => $_POST['house-road-verification-land-buyer-name-column'],
            'house_road_verification_land_buyer_spouse_name_column' => $_POST['house-road-verification-land-buyer-spouse-name-column'],
            'house_road_verification_land_buyer_citizenship_number_column' => $_POST['house-road-verification-land-buyer-citizenship-number-column'],
            'house_road_verification_land_buyer_citizenship_district_column' => $_POST['house-road-verification-land-buyer-citizenship-district-column'],
            'house_road_verification_land_buyer_province_column' => $_POST['house-road-verification-land-buyer-province-column'],
            'house_road_verification_land_buyer_district_column' => $_POST['house-road-verification-land-buyer-district-column'],
            'house_road_verification_land_buyer_municipality_column' => $_POST['house-road-verification-land-buyer-municipality-column'],
            'house_road_verification_land_buyer_ward_column' => $_POST['house-road-verification-land-buyer-ward-column'],
            'house_road_verification_citizenship_column' => $citizenship_document,
            'house_road_verification_land_ownership_column' => $land_ownership_document,
            'house_road_verification_land_map_column' => $land_map_document,
            'house_road_verification_land_tax_column' => $land_tax_document
        );

        $_SESSION['house_road_verification_form_data'][] = $house_road_verification_form_data_array;

        header("Location: ../../wadaUsers/wadaUsersApplication/house_road_verification.php");
    } else {
        echo "Please fill all the fields.";
    }
} else {
    echo "Invalid request method. Please use POST.";
}
