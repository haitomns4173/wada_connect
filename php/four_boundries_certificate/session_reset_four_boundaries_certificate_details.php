<?php
    session_start();

    $four_boundries_folder = '../../wadaMemberDocuments/session/';
    if(isset($_SESSION['four_boundaries_form_data'])){
        foreach ($_SESSION['four_boundaries_form_data'] as $key => $value) {
            $file = $four_boundries_folder . $value['four_boundaries_citizenship_document'];
            if (file_exists($file)) {
                unlink($file);
            }
            $file = $four_boundries_folder . $value['four_boundaries_land_ownership_document'];
            if (file_exists($file)) {
                unlink($file);
            }
            $file = $four_boundries_folder . $value['four_boundaries_land_tax_document'];
            if (file_exists($file)) {
                unlink($file);
            }
            $file = $four_boundries_folder . $value['four_boundaries_land_map_document'];
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }

    if(isset($_SESSION['four_boundaries_form_data'])) {
        unset($_SESSION['four_boundaries_form_data']);
    }
    header("Location: ../../wadaUsers/wadaUsersApplication/four_boundaries_certificate.php");
?>