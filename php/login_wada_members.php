<?php
session_start();
require_once 'database_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['wadaMemberUsername'];
    $password = $_POST['wadaMemberPassword'];

    $mysqli = db_connect();
    $stmt = $mysqli->prepare("SELECT usersLoginID, userPassword, userType FROM wadamemberlogindata WHERE userUsername = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($usersLoginID, $userPassword, $userType);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $userPassword)) {
        $stmt = $mysqli->prepare("UPDATE wadamemberlogindata SET userLastLogin = CURRENT_TIMESTAMP WHERE usersLoginID = ?");
        $stmt->bind_param('i', $usersLoginID);
        $stmt->execute();

        $stmt = $mysqli->prepare("SELECT `wadaMemberID` FROM `wadamemberpersonaldetails` WHERE wadaMemberUserLoginID = ?");
        $stmt->bind_param('i', $usersLoginID);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($wadaMemberID);
        $stmt->fetch();

        $_SESSION['userLoginStatus'] = true;
        $_SESSION['wadaMemberUserLoginID'] = $usersLoginID;

        if (empty($wadaMemberID)) {
            $_SESSION['wadaMemberID'] = 0;
        }
        else{
            $_SESSION['wadaMemberID'] = $wadaMemberID;
        }

        $_SESSION['wadaMemberUsername'] = $username;
        $_SESSION['wadaMemberUserType'] = $userType;

        if($userType == 2){
            header("Location: ../wadaOffice/index.php");
        }
        else{
            header("Location: ../wadaUsers/index.php");
        }
        
    } else {
        echo "Invalid username or password.";
    }

    $stmt->close();
    db_close($mysqli);
}
?>
