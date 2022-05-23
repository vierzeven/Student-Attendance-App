<?php
require_once('../../private/credentials.php');
$dbc = mysqli_connect(HOST, USER, PASS, DB) or die ('Error connecting.');
$query = "SELECT studenten.id FROM registraties INNER JOIN studenten ON registraties.student_id = studenten.id WHERE datum = CURDATE() AND type = 1";
$result = mysqli_query($dbc, $query);
if ($result) {
    $aanwezige_studenten = [];
    while ($row = mysqli_fetch_array($result)) {
        $aanwezige_studenten[] = $row['id'];
    }
    echo json_encode($aanwezige_studenten);
} else {
    echo 'Fail';
}

