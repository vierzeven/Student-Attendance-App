<?php
    $urlparts = explode('/', $_SERVER['REQUEST_URI']);
    $url =  $urlparts[sizeof($urlparts) - 1];
    $urlparts = explode('?', $url);
    $url = $urlparts[0];
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/ede87ea5dc.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/inside.css">
    <link rel="stylesheet" href="css/insidemobile.css">
    <!--    FAVICON LINKS -->
    <link rel="apple-touch-icon" sizes="72x72" href="images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
    <link rel="manifest" href="images/favicon/site.webmanifest">
    <link rel="mask-icon" href="images/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="images/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="images/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <!--    END OF FAVICON LINKS -->
    <title>Presenties AO</title>
</head>

<body>
