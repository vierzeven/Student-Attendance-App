<?php
require_once('../../private/credentials.php');
$dbc = mysqli_connect(HOST, USER, PASS, DB) or die ('Error connecting.');
$dbc->set_charset('utf8mb4');

$id = mysqli_real_escape_string($dbc, trim($_POST['id']));
$voornaam = mysqli_real_escape_string($dbc, trim($_POST['voornaam']));
$tussenvoegsel = mysqli_real_escape_string($dbc, trim($_POST['tussenvoegsel']));
$achternaam = mysqli_real_escape_string($dbc, trim($_POST['achternaam']));
$klas = mysqli_real_escape_string($dbc, trim($_POST['klas']));
$scrumteamID = mysqli_real_escape_string($dbc, trim($_POST['scrumteam']));
$ov = mysqli_real_escape_string($dbc, trim($_POST['ov']));
$github = mysqli_real_escape_string($dbc, trim($_POST['github']));
$gone = mysqli_real_escape_string($dbc, trim($_POST['gone']));


$query = "UPDATE studenten SET voornaam = '$voornaam', tussenvoegsel = '$tussenvoegsel', achternaam = '$achternaam', klas_id = $klas, scrumteams_id = $scrumteamID, ov = '$ov', github = '$github', gone = $gone WHERE id = '$id'";

$result = mysqli_query($dbc, $query) or die ('Error saving student.');
//header("Location: main_studenten.php");
header('Refresh: 0; url = main_studenten.php');
exit("Saving student");
