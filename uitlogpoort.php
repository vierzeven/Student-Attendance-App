<?php
session_start();

// Destroy session variables
session_unset();
session_destroy();

// Destroy cookies
setcookie("username", "", time() - 3600 * 24 * 7);
setcookie("token", "", time() - 3600 * 24 * 7);

// Send back to the login form
header("Refresh: 1;url=../rocdevtools/index.php");

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
<h1>Bye bye</h1>
<script src="javascript/remove_banner.js"></script>
</body>
</html>
