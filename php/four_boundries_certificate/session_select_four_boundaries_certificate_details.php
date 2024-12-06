<?php

if (!isset($_SESSION['four_boundaries_form_data'])) {
    echo "<tr><td colspan='10'><center>No Records Available.</center></td></tr>";
} else {
    if (empty($_SESSION['four_boundaries_form_data'])) {
        echo "<tr><td colspan='10'><center>No Records Available.</center></td></tr>";
    } else {
        foreach ($_SESSION['four_boundaries_form_data'] as $four_boundaries_form_values) {
            echo "<tr>";
            echo "<td>" . $four_boundaries_form_values['four_boundaries_data_id'] . "</td>";
            echo "<td>" . ucfirst($four_boundaries_form_values['four_boundaries_district']) . "</td>";
            echo "<td>" . ucfirst($four_boundaries_form_values['four_boundaries_municipality']) . "</td>";
            echo "<td>" . $four_boundaries_form_values['four_boundaries_ward'] . "</td>";
            echo "<td>" . $four_boundaries_form_values['four_boundaries_area'] . "</td>";
            echo "<td>" . $four_boundaries_form_values['four_boundaries_east'] . "</td>";
            echo "<td>" . $four_boundaries_form_values['four_boundaries_west'] . "</td>";
            echo "<td>" . $four_boundaries_form_values['four_boundaries_north'] . "</td>";
            echo "<td>" . $four_boundaries_form_values['four_boundaries_south'] . "</td>";
            echo "</tr>";
        }
    }
}

?>