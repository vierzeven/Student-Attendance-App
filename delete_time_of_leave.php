<?php

require_once('../../private/credentials.php');
$dbc = mysqli_connect(HOST, USER, PASS, DB) or die ('Error connecting.');
$s_id = mysqli_real_escape_string($dbc, trim($_POST['s_id']));
$query = "DELETE FROM registraties WHERE student_id = $s_id AND datum = CURRENT_DATE AND type = 2";
$result = mysqli_query($dbc, $query);
if ($result) {
    echo 'Removed ' . $id;
} else {
    echo 'Fail';
}
