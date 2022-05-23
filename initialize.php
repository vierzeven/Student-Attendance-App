<?php

session_start();
require_once('../../private/credentials.php');
$mysqli = new mysqli(HOST, USER, PASS, DB);
$mysqli->set_charset('utf8mb4');


if (mysqli_connect_error()) {
    die('Connect Error (' . mysqli_connect_errno() . ') '
        . mysqli_connect_error());
}

// Users without a running session are redirected to login, so the session can be reinstated using a cookie (if there is one)
if (!isset($_SESSION['coachID'])) {
//    header("Location: index.php");
    header('Refresh: 0; url = index.php');
    exit();
}

require('head.php');
require('navbar.php');

date_default_timezone_set('Europe/Amsterdam');

