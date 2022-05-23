<?php

// Start session, connect to DB, check if user is logged in, load head of page, set timezone, create new CSRF token
require('initialize.php');
require('current_timestamp.php');
$aantaldagen = isset($_GET['aantaldagen']) && !empty($_GET['aantaldagen']) ? $_GET['aantaldagen'] : 14;
// header('Refresh: 300');
?>

<div class="content">
    <table id="maintable">

        <div id="dagenteller">
            <!-- <h1>MINSTENS <span id="aantaldagen"><?php echo $aantaldagen; ?></span> DAGEN NIET AANWEZIG</h1> -->
            <h1>LANGDURIG ONGEOORLOOFD ABSENT</h1>
            <a class="dagenbutton" href="main_lang_afwezig.php?aantaldagen=<?php echo $aantaldagen + 1 ?>">+</a>
            <a class="dagenbutton" href="main_lang_afwezig.php?aantaldagen=<?php echo $aantaldagen - 1 ?>">-</a>
        </div>

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

    // research what students have entered in the last period
    $s_id = $studenten[$i]['s_id'];
    $startdate = date("Y-m-d", time() - 60 * 60 * 24 * $aantaldagen);
    $curdate = date("Y-m-d");

    $query = "SELECT tijd FROM registraties WHERE datum BETWEEN '$startdate' AND '$curdate' AND student_id = $s_id AND type = 1";
    $stmt = $mysqli->prepare($query) or die ('Error 4');
    $stmt->bind_result($r_tijd) or die ('Error 5');
    $stmt->execute() or die ('Error 6');
    $stmt->fetch();
    if (!empty($r_tijd)) {
        // Print row with time of entry
        echo '<td class="gespot" id="binnengekomen-' . $s_id . '">GESPOT</td>';
        $r_tijd = null;
    } else {
        // Print row without time of entry
        echo '<td style="display: none" class="niet-gespot" id="niet-binnengekomen-' . $s_id . '">...</td>';
    }
    $stmt->close();

    // research what students have left in the last period
    $query = "SELECT tijd FROM registraties WHERE datum BETWEEN'$startdate' AND '$curdate' AND student_id = $s_id AND type = 2";
    $stmt = $mysqli->prepare($query) or die ('Error 7');
    $stmt->bind_result($r_tijd) or die ('Error 8');
    $stmt->execute() or die ('Error 9');
    $stmt->fetch();
    if (!empty($r_tijd)) {
        // Print row with time of leave
        echo '<td class="gespot" id="vertrokken-' . $s_id . '">GESPOT</td>';
        $r_tijd = null;
    } else {
        // Print row without time of entry
        echo '<td style="display: none" class="niet-gespot" id="niet-vertrokken-' . $s_id . '">...</td>';
    }
    $stmt->close();

    // find date of last registration
    // $query = "SELECT DATEDIFF(NOW(), datum) FROM registraties WHERE student_id = $s_id ORDER BY id DESC LIMIT 1";
    // $stmt = $mysqli->prepare($query) or die ('Error 109');
    // $stmt->bind_result($r_datum) or die ('Error 8');
    // $stmt->execute() or die ('Error 110');
    // $stmt->fetch();
    // if (!empty($r_datum)) {
    //     // Print row with last date of registration
    //     echo '<td>' . $r_datum . ' dagen</td>';
    //     // $r_datum = null;
    // } else {
    //     // Print row without date
    //     echo '<td>0</td>';
    // }
    // $stmt->close();
    $query = "SELECT datum FROM registraties WHERE student_id = $s_id ORDER BY id DESC LIMIT 1";
    $stmt = $mysqli->prepare($query) or die ('Error 109');
    $stmt->bind_result($r_datum) or die ('Error 8');
    $stmt->execute() or die ('Error 110');
    $stmt->fetch();

    if (!empty($r_datum)) {
        $absentedagen = 0;
        $vandaag = date('Y-m-d');
        while ($r_datum < $vandaag) {
            $tussenstap = strtotime($r_datum);
            $r_datum = date('Y-m-d', $tussenstap + 3600 * 24);
            $weekday = date('w', $tussenstap);
            if ($weekday != 0 && $weekday != 6) {
                $absentedagen++;
            }
        }
        echo '<td>' . $absentedagen . ' dagen</td>';
        $r_datum = null;
    }
    $stmt->close();

    echo '</tr>';
}


?>


    </table>
</div>
<script src="javascript/newfunctions.js"></script>
<script src="javascript/verwijder-gespotten.js"></script>
<script src="javascript/github.js"></script>

</body>

</html>