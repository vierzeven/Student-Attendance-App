<?php

// Start session, connect to DB, check if user is logged in, load head of page, set timezone, create new CSRF token
require('initialize.php');
require('current_timestamp.php');
$aantaldagen = isset($_GET['aantaldagen']) && !empty($_GET['aantaldagen']) ? $_GET['aantaldagen'] : 14;
$cohort = isset($_GET['cohort']) ? $_GET['cohort'] : 1;

?>

<div class="content">

    <table id="maintable">

        <div id="dagenteller">
            <h1>TOTAAL AANTAL GITHUB COMMITS VOOR COHORT <?php echo $cohort; ?></h1>
            <a class="dagenbutton" href="main_github_trouble.php?cohort=<?php
            if ($cohort == 9) {
                echo '0';
            } else {
                echo $cohort + 1;
            }
            ?>">+</a>
            <a class="dagenbutton" href="main_github_trouble.php?cohort=<?php
            if ($cohort == 0) {
                echo '9';
            } else {
                echo $cohort - 1;
            }
            ?>">-</a>
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
        $query .= "FROM studenten INNER JOIN klassen ON studenten.klas_id = klassen.id WHERE klassen.naam LIKE '%{$cohort}%' ORDER BY $order_by ASC";
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


            echo '</tr>';
        }


        ?>


    </table>
</div>
<script src="javascript/newfunctions.js"></script>
<script src="javascript/github_trouble.js"></script>

</body>

</html>