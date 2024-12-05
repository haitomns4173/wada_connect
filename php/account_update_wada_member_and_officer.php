<?php
require_once 'database_connection.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['wadaMemberUserUserName']) && isset($_POST['wadaMemberUserPassword']) && isset($_POST['wadaMemberUserConfirmPassword'])) {

        $wadaMemberUserLoginID = $_SESSION['wadaMemberUserLoginID'];
        $wadaMemberUserUsername = $_POST['wadaMemberUserUserName'];
        $wadaMemberPassword = $_POST['wadaMemberUserPassword'];
        $wadaMemberConfirmPassword = $_POST['wadaMemberUserConfirmPassword'];

        $usernamePattern = "/^[a-zA-Z0-9]{5,15}$/";

        if (!preg_match($usernamePattern, $wadaMemberUserUsername)) {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = "Username must be between 5 and 15 characters and contain only letters and numbers.";
            header("Location: ../wadaUsers/applicant_account.php");
            exit;
        }
        if (strlen($wadaMemberPassword) < 8 || strlen($wadaMemberPassword) > 20) {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = "Password must be between 8 and 20 characters.";
            header("Location: ../wadaUsers/applicant_account.php");
            exit;
        }
        if ($wadaMemberPassword !== $wadaMemberConfirmPassword) {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = "Passwords do not match.";
            header("Location: ../wadaUsers/applicant_account.php");
            exit;
        }

        $mysqli = db_connect();

        $stmt = $mysqli->prepare("UPDATE `wadamemberlogindata` SET `userUsername`=?, `userPassword`= ? WHERE usersLoginID = ?");
        $hashedPassword = password_hash($wadaMemberPassword, PASSWORD_DEFAULT);
        $stmt->bind_param('sss', $wadaMemberUserUsername, $hashedPassword, $wadaMemberUserLoginID);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['status'] = 'success';
            $_SESSION['message'] = "Account Details Updated Successfully.";
            header("Location: ../wadaUsers/applicant_account.php");
            exit();
        } else {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = "Account Details Update Failed.";
            header("Location: ../wadaUsers/applicant_account.php");
            exit();
        }

        $stmt->close();
        db_close($mysqli);
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = "Invalid request!";
        header("Location: ../wadaUsers/applicant_account.php");
        exit();
    }
} else {
    $_SESSION['status'] = 'error';
    $_SESSION['message'] = "Invalid request!";
    header("Location: ../wadaUsers/applicant_account.php");
    exit();
}
