<?php

if (!isset($_SESSION['relation_certificate_verification_form_data'])) {
    echo "<tr><td colspan='7'><center>No Records Available.</center></td></tr>";
} else {
    if (empty($_SESSION['relation_certificate_verification_form_data'])) {
        echo "<tr><td colspan='7'><center>No Records Available.</center></td></tr>";
    } else {
        foreach ($_SESSION['relation_certificate_verification_form_data'] as $relation_certificate_verification_form_values) {
            echo "<tr>";
            echo "<td>" . $relation_certificate_verification_form_values['relation_certificate_data_id'] . "</td>";
            echo "<td>" . $relation_certificate_verification_form_values['relation_certificate_name_column'] . "</td>";
            echo "<td>" . $relation_certificate_verification_form_values['relation_certificate_age_column'] . "</td>";
            echo "<td>" . ucfirst($relation_certificate_verification_form_values['relation_certificate_gender_column']) . "</td>";
            echo "<td>" . ucfirst($relation_certificate_verification_form_values['relation_certification_district_column']) . "</td>";
            echo "<td>" . $relation_certificate_verification_form_values['relation_certification_relationship_column'] . "</td>";
            echo "<td><a href='../../php/relation_certificate_verification/session_reset_relation_certificate_verification_details.php?relation_certificate_data_id=" . $relation_certificate_verification_form_values['relation_certificate_data_id'] . "' class='btn btn-danger'><i class='bi bi-trash'></i></a></td>";
            echo "</tr>";
        }
    }
}
?>