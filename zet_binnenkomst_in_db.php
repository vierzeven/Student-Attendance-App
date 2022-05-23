<?php
require_once('../../private/credentials.php');
$dbc = mysqli_connect(HOST, USER, PASS, DB) or die ('Error connecting.');
$student_id = mysqli_real_escape_string($dbc, trim($_POST['id']));

require('current_timestamp.php');

$query = "SELECT * FROM registraties WHERE student_id = $student_id AND type = 1 AND datum = $date";
$result = mysqli_query($dbc, $query) or die ('Error querying.');
if (mysqli_num_rows($result) > 0) {
    die('Student is already in the house.');
}

$query = "INSERT INTO registraties VALUES (0, '$date', '$time', $student_id, 1)";
$result = mysqli_query($dbc, $query);
if ($result) {
    $query = "SELECT * FROM registraties WHERE student_id = $student_id AND type = 1 ORDER BY id DESC";
    $result = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($result);
    $time = $row['tijd'];
    echo $time;
} else {
    echo 'Fail';
}

