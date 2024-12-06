<?php
require_once '../database_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['four-boundaries-district-column']) && isset($_POST['four-boundaries-municipality-column']) && isset($_POST['four-boundaries-municipality-type-column']) && isset($_POST['four-boundaries-ward-column']) && isset($_POST['four-boundaries-kitta-number-column'])  && isset($_POST['four-boundaries-area-column']) && isset($_POST['four-boundaries-east-person-name-column']) && isset($_POST['four-boundaries-east-column'])) {
        session_start();

        if (isset($_SESSION['four_boundaries_form_data']) && count($_SESSION['four_boundaries_form_data']) > 0) {
            echo "<script>alert('One data per from is allowed.'); window.location.href = '../../wadaUsers/wadaUsersApplication/four_boundaries_certificate.php';</script>";
            exit();
        }

        if (empty($_POST['four-boundaries-west-person-name-column']) || empty($_POST['four-boundaries-west-column'])) {
            $four_boundaries_west_person_name = "N/A";
            $four_boundaries_west = "N/A";
        } else {
            $four_boundaries_west_person_name = $_POST['four-boundaries-west-person-name-column'];
            $four_boundaries_west = $_POST['four-boundaries-west-column'];
        }
        if (empty($_POST['four-boundaries-north-person-name-column']) || empty($_POST['four-boundaries-north-column'])) {
            $four_boundaries_north_person_name = "N/A";
            $four_boundaries_north = "N/A";
        } else {
            $four_boundaries_north_person_name = $_POST['four-boundaries-north-person-name-column'];
            $four_boundaries_north = $_POST['four-boundaries-north-column'];
        }
        if (empty($_POST['four-boundaries-south-person-name-column']) || empty($_POST['four-boundaries-south-column'])) {
            $four_boundaries_south_person_name = "N/A";
            $four_boundaries_south = "N/A";
        } else {
            $four_boundaries_south_person_name = $_POST['four-boundaries-south-person-name-column'];
            $four_boundaries_south = $_POST['four-boundaries-south-column'];
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

        $district_municipality_name = $_POST['four-boundaries-district-column'] . '_' . $_POST['four-boundaries-municipality-column'];

        if(isset($_FILES['four-boundaries-citizenship-column'])){
            $citizenship_document = uploadFile($_FILES['four-boundaries-citizenship-column'], $session_folder, $maxFileSize, 'citizenship', $district_municipality_name);
        } else {
            echo "Citizenship document is required.";
        }

        if(isset($_FILES['four-boundaries-land-ownership-column'])){
            $land_ownership_document = uploadFile($_FILES['four-boundaries-land-ownership-column'], $session_folder, $maxFileSize, 'land_ownership', $district_municipality_name);
        } else {
            echo "Land ownership document is required.";
        }

        if(isset($_FILES['four-boundaries-land-map-column'])){
            $land_map_document = uploadFile($_FILES['four-boundaries-land-map-column'], $session_folder, $maxFileSize, 'land_map', $district_municipality_name);
        } else {
            echo "Land map document is required.";
        }

        if(isset($_FILES['four-boundaries-land-tax-column'])){
            $land_tax_document = uploadFile($_FILES['four-boundaries-land-tax-column'], $session_folder, $maxFileSize, 'land_tax', $district_municipality_name);
        } else {
            echo "Land tax document is required.";
        }

        if (!isset($_SESSION['four_boundaries_form_data'])) {
            $_SESSION['four_boundaries_form_data'] = array();
        }

        $citizenship_document = str_replace("../../wadaMemberDocuments/session/", "", $citizenship_document);
        $land_ownership_document = str_replace("../../wadaMemberDocuments/session/", "", $land_ownership_document);
        $land_map_document = str_replace("../../wadaMemberDocuments/session/", "", $land_map_document);
        $land_tax_document = str_replace("../../wadaMemberDocuments/session/", "", $land_tax_document);

        $four_boundaries_data_id = count($_SESSION['four_boundaries_form_data']) + 1;
        $four_boundaries_form_values_array = array(
            'four_boundaries_data_id' => $four_boundaries_data_id,
            'four_boundaries_district' => $_POST['four-boundaries-district-column'],
            'four_boundaries_municipality' => $_POST['four-boundaries-municipality-column'],
            'four_boundaries_municipality_type' => $_POST['four-boundaries-municipality-type-column'],
            'four_boundaries_ward' => $_POST['four-boundaries-ward-column'],
            'four_boundaries_kitta_number' => $_POST['four-boundaries-kitta-number-column'],
            'four_boundaries_area' => $_POST['four-boundaries-area-column'],
            'four_boundaries_east_person_name' => $_POST['four-boundaries-east-person-name-column'],
            'four_boundaries_east' => $_POST['four-boundaries-east-column'],
            'four_boundaries_west_person_name' => $four_boundaries_west_person_name,
            'four_boundaries_west' => $four_boundaries_west,
            'four_boundaries_north_person_name' => $four_boundaries_north_person_name,
            'four_boundaries_north' => $four_boundaries_north,
            'four_boundaries_south_person_name' => $four_boundaries_south_person_name,
            'four_boundaries_south' => $four_boundaries_south,
            'four_boundaries_citizenship_column' => $citizenship_document,
            'four_boundaries_land_ownership_column' => $land_ownership_document,
            'four_boundaries_land_map_column' => $land_map_document,
            'four_boundaries_land_tax_column' => $land_tax_document
        );

        $_SESSION['four_boundaries_form_data'][] = $four_boundaries_form_values_array;

        header("Location: ../../wadaUsers/wadaUsersApplication/four_boundaries_certificate.php");
    } else {
        echo "District, Municipality, Ward, Area, East, West, North, South columns are required.";
    }
} else {
    echo "Invalid request method. Please use POST.";
}
