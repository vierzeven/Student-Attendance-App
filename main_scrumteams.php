<?php

// Start session, connect to DB, check if user is logged in, load head of page, set timezone, create new CSRF token
require('initialize.php');
require('current_timestamp.php');
header('Refresh: 300');

?>



<?php

echo '<div id="absenties">';

$query_class = "SELECT id as scrumteamID FROM scrumteams ORDER BY scrumteamID";
$result_class = mysqli_query($mysqli, $query_class) or die('Error querying for classes.');
while ($class = mysqli_fetch_array($result_class)) {
    $scrumteamID = $class['scrumteamID'];
    $naam_class   = "TEAM {$scrumteamID}";
    echo '<div class="absenties-in-klas">';
    echo '<p class="classname">' . $naam_class . '</p><div class="absentielijst">';
    $query_students  = "SELECT * FROM studenten WHERE scrumteams_id = $scrumteamID AND studenten.gone = 0 ORDER BY voornaam ASC";
    $result_students = mysqli_query($mysqli, $query_students) or die('Error querying for students.');
    while ($students = mysqli_fetch_array($result_students)) {
//        $id_student = $students['id'];
//        $query_arrival = "SELECT *, studenten.voornaam, studenten.gone AS voornaam FROM registraties INNER JOIN studenten ON registraties.student_id = studenten.id WHERE registraties.student_id = $id_student AND registraties.datum = CURRENT_DATE";
//        $result_arrival = mysqli_query($mysqli, $query_arrival) or die('Error querying for arrival.');
//        if (mysqli_num_rows($result_arrival) == 0) {
            echo '<div>' . $students['voornaam'] . ' ' . $students['tussenvoegsel'] . ' ' . $students['achternaam'] . '</div>';
//        }
    }
    echo '</div></div>';
}
echo '</div>';


?>




<script src="javascript/initialize_buttons.js"></script>
<script src="javascript/verwijder_functies.js"></script>
<script src="javascript/remove_banner.js"></script>

</body>

</html>