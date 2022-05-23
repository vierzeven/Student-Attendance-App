<?php
session_start();
require_once('../../private/credentials.php');
$dbc = mysqli_connect(HOST, USER, PASS, DB) or die ('Error connecting.');

// Users with a running session are redirected to the homepage
if (isset($_SESSION['username'])) {
    header("Location: main_presenties.php");
}

// Users without a running session, but with a valid cookie, are also redirected to the homepage
if (isset($_COOKIE['username']) AND isset($_COOKIE['hash'])) {
    $username = mysqli_real_escape_string($dbc, trim($_COOKIE['username']));
    $hash = mysqli_real_escape_string($dbc, trim($_COOKIE['hash']));
    $query = "SELECT * FROM users WHERE naam = '$username' AND hash = '$hash'";
    $result = mysqli_query($dbc, $query) or die ('Error querying.');
    $numrows = mysqli_num_rows($result);
    if ($numrows > 0) {
        $_SESSION['username'] = $username;
        header("Location: main_presenties.php");
    }
}

// Set CSRF-token to prevent XSS
$csrf_token = hash('sha512', time());
$_SESSION['csrf_token'] = $csrf_token;

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/outside.css">
    <title>Presenties AO</title>
</head>
<body>

<form id="loginform" action="inlogpoort.php" method="post">
    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
    <label for="username">Username</label>
    <input type="text" name="username" id="username">
    <label for="password">Password</label>
    <input type="password" name="password" id="password">
    <input type="submit" name="submit" id="submit">
</form>

<!-- <script src="javascript/remove_banner.js"></script> -->
</body>
</html>
