<?php
    session_start();

    $relation_session_folder = '../../wadaMemberDocuments/session/';
    if(isset($_SESSION['electricity_connection_form_data'])) {
        foreach ($_SESSION['electricity_connection_form_data'] as $key => $value) {
            $file = $relation_session_folder . $value['electricity-connection-citizenship-document'];
            if (file_exists($file)) {
                unlink($file);
            }
            $file = $relation_session_folder . $value['electricity-connection-land-ownership-document'];
            if (file_exists($file)) {
                unlink($file);
            }
            $file = $relation_session_folder . $value['electricity-connection-land-tax-document'];
            if (file_exists($file)) {
                unlink($file);
            }
            $file = $relation_session_folder . $value['electricity-connection-land-map-document'];
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }

    if(isset($_SESSION['electricity_connection_form_data'])) {
        unset($_SESSION['electricity_connection_form_data']);
    }
    header("Location: ../../wadaUsers/wadaUsersApplication/electricity_connection_recommendation.php");
?>