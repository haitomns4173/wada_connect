<?php
require_once '../database_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['relation-certificate-name-column']) && isset($_POST['relation-certificate-age-column']) && isset($_POST['relation-certificate-gender-column']) && isset($_POST['relation-certification-relationship-column']) && isset($_POST['relation-certification-district-column']) && isset($_POST['relation-certification-municipality-column']) && isset($_POST['relation-certification-municipality-type-column']) && isset($_POST['relation-certification-ward-column'])) {
        session_start();

        if (isset($_SESSION['relation_certificate_verification_form_data']) && count($_SESSION['relation_certificate_verification_form_data']) > 0) {
            echo "<script>alert('One data per from is allowed.'); window.location.href = '../../wadaUsers/wadaUsersApplication/relation_certificate_verification.php';</script>";
            exit();
        }

        if (!preg_match("/^[\x{0900}-\x{097F}\s]+$/u", $_POST['relation-certificate-name-column'])) {
            echo "Only Nepali characters are allowed in First name and Last name.";
        }
        if(!preg_match("/^[0-9]*$/", $_POST['relation-certificate-age-column'])){
            echo "Only a valid number is allowed in Age.";
        }
        if(!preg_match("/^[0-9]*$/", $_POST['relation-certification-ward-column'])){
            echo "Only a valid number is allowed in Ward.";
        }

        $main_folder = '../../wadaMemberDocuments/';
        $session_folder = $main_folder . 'session/';

        if (!file_exists($session_folder)) {
            mkdir($session_folder, 0755, true);
        }

        $maxFileSize = 500 * 1024;

        function generateFileName($fileName, $type, $full_name)
        {
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $baseFileName = "{$full_name}_{$type}_" . uniqid();
            return "{$baseFileName}.{$fileExtension}";
        }

        function uploadFile($file, $folder, $maxFileSize, $type, $full_name)
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

            $uniqueFileName = generateFileName($file["name"], $type, $full_name);
            $target_file = $folder . $uniqueFileName;

            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                return $target_file;
            } else {
                return false;
            }
        }

        if (!empty($_FILES["relation-certification-citizenship-column"]["name"])) {
            $relation_certificate_citizenship_document = uploadFile($_FILES["relation-certification-citizenship-column"], $session_folder, $maxFileSize, 'RelationCertificateVerification', $_POST['relation-certificate-name-column']);
            if (!$relation_certificate_citizenship_document) {
                echo "Failed to upload Profile Image.";
                exit;
            }
        }
        else{
            echo "Please upload the citizenship document.";
            exit;
        }

        if (!isset($_SESSION['relation_certificate_verification_form_data'])) {
            $_SESSION['relation_certificate_verification_form_data'] = array();
        }

        $relation_certificate_citizenship_document = str_replace("../../wadaMemberDocuments/session/", "", $relation_certificate_citizenship_document);

        $relation_certificate_verification_form_data_id = count($_SESSION['relation_certificate_verification_form_data']) + 1;
        $relation_certificate_verification_form_data_array = array(
            'relation_certificate_data_id' => $relation_certificate_verification_form_data_id,
            'relation_certificate_name_column' => $_POST['relation-certificate-name-column'],
            'relation_certificate_age_column' => $_POST['relation-certificate-age-column'],
            'relation_certificate_gender_column' => $_POST['relation-certificate-gender-column'],
            'relation_certification_relationship_column' => $_POST['relation-certification-relationship-column'],
            'relation_certification_district_column' => $_POST['relation-certification-district-column'],
            'relation_certification_municipality_column' => $_POST['relation-certification-municipality-column'],
            'relation_certification_municipality_type_column' => $_POST['relation-certification-municipality-type-column'],
            'relation_certification_ward_column' => $_POST['relation-certification-ward-column'],
            'relation_certification_citizenship_column' => $relation_certificate_citizenship_document,
        );

        $_SESSION['relation_certificate_verification_form_data'][] = $relation_certificate_verification_form_data_array;

        header("Location: ../../wadaUsers/wadaUsersApplication/relation_certificate_verification.php");
    } else {
        echo "Please fill all the fields.";
    }
} else {
    echo "Invalid request method. Please use POST.";
}
