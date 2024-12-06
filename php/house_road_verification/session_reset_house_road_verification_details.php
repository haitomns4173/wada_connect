<?php
    session_start();

    $house_road_session_folder = '../../wadaMemberDocuments/session/';
    if(isset($_SESSION['house_road_verification_form_data'])) {
        foreach ($_SESSION['house_road_verification_form_data'] as $key => $value) {
            $file = $house_road_session_folder . $value['house_road_verification_citizenship_column'];
            if (file_exists($file)) {
                unlink($file);
            }
            $file = $house_road_session_folder . $value['house_road_verification_land_ownership_column'];
            if (file_exists($file)) {
                unlink($file);
            }
            $file = $house_road_session_folder . $value['house_road_verification_land_tax_column'];
            if (file_exists($file)) {
                unlink($file);
            }
            $file = $house_road_session_folder . $value['house_road_verification_land_map_column'];
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }

    if(isset($_SESSION['house_road_verification_form_data'])) {
        unset($_SESSION['house_road_verification_form_data']);
    }
    header("Location: ../../wadaUsers/wadaUsersApplication/house_road_verification.php");
?>