<?php

if (!isset($_SESSION['house_road_verification_form_data'])) {
    echo "<tr><td colspan='7'><center>No Records Available.</center></td></tr>";
} else {
    if (empty($_SESSION['house_road_verification_form_data'])) {
        echo "<tr><td colspan='7'><center>No Records Available.</center></td></tr>";
    } else {
        foreach ($_SESSION['house_road_verification_form_data'] as $house_road_verification_form_values) {
            echo "<tr>";
            echo "<td>" . $house_road_verification_form_values['house_road_data_id'] . "</td>";
            echo "<td>" . ucfirst($house_road_verification_form_values['house_road_verification_municipality_column']) . "</td>";
            echo "<td>" . $house_road_verification_form_values['house_road_verification_ward_column'] . "</td>";
            echo "<td>" . $house_road_verification_form_values['house_road_verification_map_column'] . "</td>";
            echo "<td>" . $house_road_verification_form_values['house_road_verification_kitta_number_column'] . "</td>";
            echo "<td>" . $house_road_verification_form_values['house_road_verification_area_column'] . "</td>";
            echo "<td>" . $house_road_verification_form_values['house_road_verification_road_presence_column'] . "</td>";
            echo "</tr>";
        }
    }
}

?>