<?php
    require_once 'database_connection.php'; 

    $mysqli = db_connect();

    if($mysqli){
        $stmt = $mysqli->prepare("SELECT * FROM `wadaconnectapplicationlisting` INNER JOIN `wadaconnectapplicationtype` ON wadaConnectApplicationType = wadaConnectApplicationTypeID INNER JOIN `wadamemberpersonaldetails` ON `wadaMemberID` = `wadaConnectApplicationUserID` WHERE wadaConnectApplicationWadaSentStatus = 'Sent' AND wadaConnectApplicationStatus != 'Approved' ORDER BY wadaConnectApplicationListingID DESC;");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        $applicationCounter = 1;
        
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){

                if($row['wadaConnectApplicationType'] == 1){
                    $applicationType = "Four Boundaries Certificate";
                }
                else if($row['wadaConnectApplicationType'] == 2){
                    $applicationType = "Electricity Connection Recommendation";
                }
                else if($row['wadaConnectApplicationType'] == 3){
                    $applicationType = "Relation Certificate Verification";
                }
                else{
                    $applicationType = "House Road Verification";
                }

                echo "<tr>";
                echo "<td>".$applicationCounter++."</td>";
                echo "<td>" . $row['wadaConnectApplicationListingID'] . " - " . $row['wadaConnectApplicationID'] . " - " . $row['wadaConnectApplicationUserID'] . " - " . $row['wadaConnectApplicationType'] . "</td>";
                echo "<td>".$row['wadaMemberFirstName']." ".$row['wadaMemberMiddleName']." ".$row['wadaMemberLastName']."</td>";
                echo "<td>".$applicationType."</td>";
                echo "<td>".$row['wadaConnectApplicationDateTime']."</td>";
                echo "<td>";
                if ($row['wadaConnectApplicationStatus'] == 'Pending') {
                    echo "<span class='badge bg-light-primary'> " . $row['wadaConnectApplicationStatus'] . "</span>";
                  } else if ($row['wadaConnectApplicationStatus'] == 'Processing') {
                    echo "<span class='badge bg-light-warning'> " . $row['wadaConnectApplicationStatus'] . "</span>";
                  } else if ($row['wadaConnectApplicationStatus'] == 'Approved') {
                    echo "<span class='badge bg-light-success'> " . $row['wadaConnectApplicationStatus'] . "</span>";
                  } else if ($row['wadaConnectApplicationStatus'] == 'Rejected') {
                    echo "<span class='badge bg-light-danger'> " . $row['wadaConnectApplicationStatus'] . "</span>";
                  }
                echo "</td>";
                echo "<td><a href='application_view.php?wadaConnectApplicationID=".$row['wadaConnectApplicationListingID']."&wadaConnectApplicationUserID=".$row['wadaConnectApplicationUserID']."' class='btn icon btn-primary'> <i class='bi bi-eye'></i></a></td>";
                echo "</tr>";
            }
        }
        else{
            echo "<tr><td colspan='7'><center>No Applications Received</center></td></tr>";
        }

        db_close($mysqli);
    }
    else{
        echo "Database Connection Error";
    }
?>