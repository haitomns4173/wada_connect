<?php

if (!isset($_SESSION['electricity_connection_form_data'])) {
    echo "<tr><td colspan='7'><center>No Records Available.</center></td></tr>";
} else {
    if (empty($_SESSION['electricity_connection_form_data'])) {
        echo "<tr><td colspan='7'><center>No Records Available.</center></td></tr>";
    } else {
        foreach ($_SESSION['electricity_connection_form_data'] as $electricity_connection_form_values) {
            echo "<tr>";
            echo "<td>" . $electricity_connection_form_values['electricity_connection_form_data_id'] . "</td>";
            echo "<td>" . ucfirst($electricity_connection_form_values['electricity-connection-district']) . "</td>";
            echo "<td>" . ucfirst($electricity_connection_form_values['electricity-connection-municipality']) . "</td>";
            echo "<td>" . $electricity_connection_form_values['electricity-connection-map'] . "</td>";
            echo "<td>" . $electricity_connection_form_values['electricity-connection-ward'] . "</td>";
            echo "<td>" . $electricity_connection_form_values['electricity-connection-kitta-number'] . "</td>";
            echo "<td>" . $electricity_connection_form_values['electricity-connection-area'] . "</td>";
            echo "</tr>";
        }
    }
}

?>