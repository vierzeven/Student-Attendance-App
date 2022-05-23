<?php

/**
 * @var $mysqli mysqli
 */

// Start session, connect to DB, check if user is logged in, load head of page, set timezone, create new CSRF token
require('initialize.php');
require('current_timestamp.php');
header('Refresh: 300');

$showtime = (isset($_GET['showtime']) AND $_GET['showtime'] == 1) ? 1 : 0;

?>

<?php

echo '<div id="weekoverzicht">';

if ($showtime) {
    echo '<a href="main_absenties_week.php?showtime=0"><button class="showtime-toggle">VERBERG TIJDEN</button></a>';
} else {
    echo '<a href="main_absenties_week.php?showtime=1"><button class="showtime-toggle">TOON TIJDEN</button></a>';
}
// Verzamel alle klassen
$query_class = "SELECT id, naam FROM klassen ORDER BY klassen.naam";
$result_class = mysqli_query($mysqli, $query_class) or die('Error querying for classes.');

// Doorloop alle klassen
while ($class = mysqli_fetch_array($result_class)) {

    // Pak de ID en naam van de klas
    $id_class = $class['id'];
    $naam_class = $class['naam'];

    // Creëer de HTML structuur en print de naam van de klas
    echo '<div class="absenties-in-klas">';
    echo '<div class="tabelheader">';
    echo '<div class="classname">' . $naam_class . '</div>';

    // Print de kopjes van de tabel (met de dag en datum)
    for ($i = 9; $i >= 0; $i--) {

        // We checken eerst welke dag van de week deze datum is, omdat het weekend grijs moet worden
        $day = date("D", time() - $i * 60 * 60 * 24);
        if ($day == 'Sat' OR $day == 'Sun') {
            echo '<div class="weekend">' . date("D j-m", time() - $i * 60 * 60 * 24) . '</div>';
        } else {
            echo '<div class="datum">' . date("D j-m", time() - $i * 60 * 60 * 24) . '</div>';
        }
    }
    echo '</div>';

    echo '<div class="absentielijst">';

    // Verzamel uit de huidige klas alle studenten
    $query_students = "SELECT * FROM studenten WHERE klas_id = $id_class AND studenten.gone = 0 ORDER BY achternaam ASC";
    $result_students = mysqli_query($mysqli, $query_students) or die('Error querying for students.');

    // Doorloop de lijst met studenten uit deze klas...
    while ($students = mysqli_fetch_array($result_students)) {

        // Pak eerst de ID van de student...
        $id_student = $students['id'];

        // Creëer de HTML structuur...
        echo '<div id="registraties">';

        // Print de naam van de student
        echo '<div class="studentname">' . $students['voornaam'] . ' ' . $students['tussenvoegsel'] . ' ' . $students['achternaam'] . '</div>';

        // Print voor de afgelopen 10 dagen de presenties...
        for ($i = 9; $i >= 0; $i--) {

            echo '<div class="blokjes">';

            $query_arrival = "SELECT * FROM registraties INNER JOIN studenten ON registraties.student_id = studenten.id WHERE registraties.student_id = $id_student AND registraties.datum = subdate(current_date, $i) AND registraties.type = 1";
            $result_arrival = mysqli_query($mysqli, $query_arrival) or die('Error querying for arrival.');
            $arrival = mysqli_fetch_array($result_arrival);
            $day = date("D", time() - $i * 60 * 60 * 24);
            if ($day == 'Sat' OR $day == 'Sun') {
                echo '<div class="grey"></div>';
            } else if (mysqli_num_rows($result_arrival) == 0) {
                echo '<div class="red"></div>';
            } else if ($showtime) {
                echo '<div class="arr green">' . $arrival['tijd'] . '</div>';
            } else {
                echo '<div class="arr green"></div>';
            }

            $query_departure = "SELECT * FROM registraties INNER JOIN studenten ON registraties.student_id = studenten.id WHERE registraties.student_id = $id_student AND registraties.datum = subdate(current_date, $i) AND registraties.type = 2";
            $result_departure = mysqli_query($mysqli, $query_departure) or die('Error querying for arrival.');
            $departure = mysqli_fetch_array($result_departure);
            if ($day == 'Sat' OR $day == 'Sun') {
                echo '<div class="grey"></div>';
            } else if (mysqli_num_rows($result_departure) == 0) {
                echo '<div class="red"></div>';
            } else if ($showtime) {
                echo '<div class="dep green">' . $departure['tijd'] . '</div>';
            } else {
                echo '<div class="dep green"></div>';
            }
            echo '</div>';
        }
        echo '</div>';
    }
    echo '</div></div>';
}
echo '</div>';


?>


<script src="javascript/initialize_buttons.js"></script>
<script src="javascript/verwijder_functies.js"></script>

</body>

</html>