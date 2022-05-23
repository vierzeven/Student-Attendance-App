<?php
//require_once('../../private/credentials.php');
//$dbc = mysqli_connect(HOST, USER, PASS, DB) or die ('Error connecting.');
//$id = mysqli_real_escape_string($dbc, trim($_POST['id']));
//$query = "DELETE FROM studenten WHERE id = '$id'";
//$result = mysqli_query($dbc, $query) or die ('Error querying with id ' . $id);
//if ($result) {
//    echo 'Removed ' . $id;
//} else {
//    echo 'Fail';
//}


require_once('../../private/credentials.php');
$dbc = mysqli_connect(HOST, USER, PASS, DB) or die ('Error connecting.');
$id = mysqli_real_escape_string($dbc, trim($_POST['id']));

$query = "SELECT studenten.id FROM studenten INNER JOIN klassen ON studenten.klas_id = klassen.id WHERE klassen.id = $id";
$result = mysqli_query($dbc, $query) or die ('Error 6');
$numrows = mysqli_num_rows($result);

if ($numrows == 0) {
    $query = "DELETE FROM klassen WHERE id = $id";
    $result = mysqli_query($dbc, $query);
    if ($result) {
        echo 'Removed ' . $id;
    } else {
        echo 'Fail';
    }
} else {
    echo 'Fail';
}