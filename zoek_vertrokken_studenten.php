<?php
require_once('../../private/credentials.php');
$dbc = mysqli_connect(HOST, USER, PASS, DB) or die ('Error connecting.');
$query = "SELECT studenten.id FROM registraties INNER JOIN studenten ON registraties.student_id = studenten.id WHERE datum = CURDATE() AND type = 2";
$result = mysqli_query($dbc, $query);
if ($result) {
    $vertrokken_studenten = [];
    while ($row = mysqli_fetch_array($result)) {
        $vertrokken_studenten[] = $row['id'];
    }
    echo json_encode($vertrokken_studenten);
} else {
    echo 'Fail';
}

