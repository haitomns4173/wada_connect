<?php
    session_start();

    $relation_session_folder = '../../wadaMemberDocuments/session/';
    if(isset($_SESSION['relation_certificate_verification_form_data'])) {
        foreach ($_SESSION['relation_certificate_verification_form_data'] as $key => $value) {
            $file = $relation_session_folder . $value['relation_certification_citizenship_column'];
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }

    if(isset($_SESSION['relation_certificate_verification_form_data'])) {
        unset($_SESSION['relation_certificate_verification_form_data']);
    }
    header("Location: ../../wadaUsers/wadaUsersApplication/relation_certificate_verification.php");
?>