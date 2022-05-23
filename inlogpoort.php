<?php

// Prepare by setting up the session and the database connection
session_start();
require_once('../../private/credentials.php');
$dbc = mysqli_connect(HOST, USER, PASS, DB) or die ('Error connecting.');

// Create a function for sending users back to the login screen
function sendBackToIndex($msg) {
    session_unset();
    session_destroy();
    header("Refresh: 2;url=../rocdevtools/index.php");
    exit("Whoops! $msg");
}

// Revert users that haven't come here by clicking the submit button
if (!isset($_POST['submit'])) {
    sendBackToIndex("18");
}

// Revert users that have come here without a CSRF-token
if (!isset($_POST['csrf_token'])) {
    sendBackToIndex("23");
}

// Extract the CSRF-token from the POST-array
$csrf_token = $_POST['csrf_token'];

// Revert users when there is no CSRF-token in session
if (!isset($_SESSION['csrf_token'])) {
    sendBackToIndex("31");
}

// Extract the CSRF-token from the SESSION-array
$csrf_token_from_session = $_SESSION['csrf_token'];

// Revert users that have come here with a faulty CSRF-token
if ($csrf_token != $csrf_token_from_session) {
    sendBackToIndex("39");
}

// Revert users that haven't completely filled out the login form
if (!isset($_POST['username']) || !isset($_POST['password'])) {
    sendBackToIndex("44");
}

// Extract and sanitize the login credentials
$username = mysqli_real_escape_string($dbc, trim($_POST['username']));
$password = mysqli_real_escape_string($dbc, trim($_POST['password']));

// Encrypt password
$password = hash('sha512', $password);

// Verify login credentials and revert users that don't have the right ones
$query = "SELECT * FROM coaches WHERE email = '$username' AND password = '$password'";
$result = mysqli_query($dbc, $query) or die ('Error querying.');
$succes = mysqli_num_rows($result);
if ($succes > 0) {
    $row = mysqli_fetch_array($result);

    $coachID = $row['id'];
    $email = $row['email'];
    $token = $row['token'];

    $_SESSION['coachID'] = $coachID;
    $_SESSION['email'] = $email;
    $_SESSION['token'] = $token;

    setcookie("coachID", $coachID, time() + 3600 * 24 * 7);
    setcookie("email", $email, time() + 3600 * 24 * 7);
    setcookie("token", $token, time() + 3600 * 24 * 7);

    header('Refresh: 0; url = main_presenties.php');
    exit();
} else {
    sendBackToIndex("76");
}

?>
</body>
</html>
