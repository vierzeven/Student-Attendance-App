<?php
require('current_timestamp.php');
require_once('../../private/credentials.php');
$dbc = mysqli_connect(HOST, USER, PASS, DB) or die ('Error connecting.');
$s_id = mysqli_real_escape_string($dbc, trim($_POST['s_id']));
$query = "INSERT INTO registraties VALUES (0, '$date', '$time', $s_id, 1)";
$result = mysqli_query($dbc, $query);
if ($result) {
    echo 'Saved ' . $id;
} else {
    echo 'Fail';
}
