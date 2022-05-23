<?php

// Start session, connect to DB, check if user is logged in, load head of page, set timezone, create new CSRF token
require('initialize.php');
require('current_timestamp.php');
// header('Refresh: 300');
?>

<div class="content">
    <table id="maintable">

        <tr id="sorteerknoppen">
            <td><a href="main_presenties.php?order_by=studenten.ov">OV <i class="fas fa-sort"></i></a></td>
            <td><a href="main_presenties.php?order_by=klassen.naam">KLAS <i class="fas fa-sort"></i></a></td>
            <td><a href="main_presenties.php?order_by=studenten.voornaam">VOORNAAM <i class="fas fa-sort"></i></a></td>
            <td></td>
            <td><a href="main_presenties.php?order_by=studenten.achternaam">ACHTERNAAM <i class="fas fa-sort"></i></a>
            </td>
            <td>GITHUB</td>
            <td>BINNENKOMST</td>
            <td>VERTREK</td>
            <td>ABSENT</td>
        </tr>

<?php

if (empty($_GET['order_by'])) {
    $order_by = 'studenten.voornaam';
} else {
    $order_by = $_GET['order_by'];
}

// fetch ALL students
$all_students = [];
$query = "SELECT studenten.id, studenten.ov, studenten.github, klassen.naam AS klas, studenten.voornaam, studenten.tussenvoegsel, studenten.achternaam, studenten.gone ";
$query .= "FROM studenten INNER JOIN klassen ON studenten.klas_id = klassen.id ORDER BY $order_by ASC";
$stmt = $mysqli->prepare($query) or die ('Error 1');
$stmt->bind_result($s_id, $s_ov, $s_github, $s_klas, $s_voornaam, $s_tussenvoegsel, $s_achternaam, $s_gone) or die ('Error 2');
$stmt->execute() or die ('Error 3');
while ($student = $stmt->fetch()) {
    if (!$s_gone) {
        $studenten[] = [
            's_id' => $s_id,
            's_ov' => $s_ov,
            's_github' => $s_github,
            's_klas' => $s_klas,
            's_voornaam' => $s_voornaam,
            's_tussenvoegsel' => $s_tussenvoegsel,
            's_achternaam' => $s_achternaam
        ];
    }
}
$stmt->close();

for ($i = 0; $i < sizeof($studenten); $i++) {
    echo '<tr class="studentrow">';
    echo '<td class="ov">' . $studenten[$i]['s_ov'] . '</td>';
    echo '<td class="klas">' . $studenten[$i]['s_klas'] . '</td>';
    echo '<td class="voornaam">' . $studenten[$i]['s_voornaam'] . '</td>';
    echo '<td class="tsv">' . $studenten[$i]['s_tussenvoegsel'] . '</td>';
    echo '<td class="achternaam">' . $studenten[$i]['s_achternaam'] . '</td>';
    if (!empty($studenten[$i]['s_github'])) {
        echo '
        <td class="github">
            <a href="https://www.github.com/' . $studenten[$i]['s_github'] . '" target="blank">
                <i class="fab fa-github-square"></i>
            </a>
        </td>';
    } else {
        echo '<td class="github"></td>';
    }

    // research what students have entered
    $s_id = $studenten[$i]['s_id'];
    $curdate = date("Y-m-d");
    $query = "SELECT tijd FROM registraties WHERE datum = '$curdate' AND student_id = $s_id AND type = 1";
    $stmt = $mysqli->prepare($query) or die ('Error 4');
    $stmt->bind_result($r_tijd) or die ('Error 5');
    $stmt->execute() or die ('Error 6');
    $stmt->fetch();
    if (!empty($r_tijd)) {
        // Print row with time of entry
        echo '<td class="binnenkomst" id="binnenkomst-' . $s_id . '">' . $r_tijd . '</td>';
        $r_tijd = null;
    } else {
        // Print row without time of entry
        echo '<td class="binnenkomst" id="binnenkomst-' . $s_id . '">...</td>';
    }
    $stmt->close();

    // research what students have left
    $query = "SELECT tijd FROM registraties WHERE datum = '$curdate' AND student_id = $s_id AND type = 2";
    $stmt = $mysqli->prepare($query) or die ('Error 7');
    $stmt->bind_result($r_tijd) or die ('Error 8');
    $stmt->execute() or die ('Error 9');
    $stmt->fetch();
    if (!empty($r_tijd)) {
        // Print row with time of leave
        echo '<td class="vertrek" id="vertrek-' . $s_id . '">' . $r_tijd . '</td>';
        $r_tijd = null;
    } else {
        // Print row without time of entry
        echo '<td class="vertrek" id="vertrek-' . $s_id . '">...</td>';
    }
    $stmt->close();

    // find date of last registration
    $query = "SELECT DATEDIFF(NOW(), datum) FROM registraties WHERE student_id = $s_id ORDER BY id DESC LIMIT 1";
    $stmt = $mysqli->prepare($query) or die ('Error 109');
    $stmt->bind_result($r_datum) or die ('Error 8');
    $stmt->execute() or die ('Error 110');
    $stmt->fetch();
    if (!empty($r_datum)) {
        // Print row with last date of registration
        echo '<td class="last_registration">' . $r_datum . ' dagen</td>';
        // $r_datum = null;
    } else {
        // Print row without date
        echo '<td>0</td>';
    }
    $stmt->close();


    echo '</tr>';
}


?>


    </table>
</div>
<script src="javascript/newfunctions.js"></script>
<script src="javascript/github.js"></script>

</body>

</html>