<?php

// Start session, connect to DB, check if user is logged in, load head of page, set timezone, create new CSRF token
require('initialize.php');
require('current_timestamp.php');
header('Refresh: 300');

?>



<?php

echo '<div id="absenties">';

$query = "SELECT id, naam FROM klassen ORDER BY klassen.naam";
$result = mysqli_query($mysqli, $query) or die('Error querying for classes.');
while ($class = mysqli_fetch_array($result)) {
    $id_class     = $class['id'];
    $naam_class   = $class['naam'];
    echo '<div class="absenties-in-klas-vandaag">';
    echo '<div class="classname-vandaag">' . $naam_class . '</div><div class="absentielijst-vandaag">';
    $query_students  = "SELECT * FROM studenten WHERE klas_id = $id_class AND studenten.gone = 0 ORDER BY achternaam ASC";
    $result_students = mysqli_query($mysqli, $query_students) or die('Error querying for students.');
    while ($students = mysqli_fetch_array($result_students)) {
        $id_student = $students['id'];
        $query_arrival = "SELECT * FROM registraties INNER JOIN studenten ON registraties.student_id = studenten.id WHERE registraties.student_id = $id_student AND registraties.datum = CURRENT_DATE";
        $result_arrival = mysqli_query($mysqli, $query_arrival) or die('Error querying for arrival.');
        if (mysqli_num_rows($result_arrival) == 0) {
            echo '<div>' . $students['voornaam'] . ' ' . $students['tussenvoegsel'] . ' ' . $students['achternaam'] . '</div>';
        }
    }
    echo '</div></div>';
}
echo '</div>';


?>




<script src="javascript/initialize_buttons.js"></script>
<script src="javascript/verwijder_functies.js"></script>

</body>

</html>