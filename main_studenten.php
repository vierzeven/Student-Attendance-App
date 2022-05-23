<?php

require('initialize.php');

if (isset($_POST['submit']) && $_POST['submit'] === 'VOEG TOE' && isset($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token']) {
    $klas = $_POST['klas'];
    $ov = $_POST['ov'];
    $scrumteam = $_POST['scrumteam'];
    $voornaam = ucfirst($_POST['voornaam']);
    $tussenvoegsel = $_POST['tussenvoegsel'];
    $achternaam = ucfirst($_POST['achternaam']);

    $query = "INSERT INTO studenten (id, voornaam, tussenvoegsel, achternaam, klas_id, scrumteams_id, ov) VALUES (0, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query) or die ('Error 1');
    $stmt->bind_param('sssiis', $voornaam, $tussenvoegsel, $achternaam, $klas, $scrumteam, $ov) or die ('Error 2');
    $stmt->execute() or die ('Error ' . $mysqli->error . 'KLAS: ' . $klas);
    $stmt->close();
}

//// Set new CSRF-token to prevent XSS
$csrf_token = hash('sha512', time());
$_SESSION['csrf_token'] = $csrf_token;

$klassen = [];
$query = "SELECT id, naam FROM klassen ORDER BY naam ASC";
$stmt = $mysqli->prepare($query) or die ('Error 4');
$stmt->bind_result($id, $naam) or die ('Error 5');
$stmt->execute() or die ('Error 6');
while ($row = $stmt->fetch()) {
    $klassen[$id] = $naam;
}
$stmt->close();

$scrumteams = [];
$query = "SELECT id FROM scrumteams ORDER BY id ASC";
$stmt = $mysqli->prepare($query) or die ('Error 4');
$stmt->bind_result($stid) or die ('Error 5');
$stmt->execute() or die ('Error 6');
while ($row = $stmt->fetch()) {
    $scrumteams[] = $stid;
}
$stmt->close();


?>

<div class="content">
    <form class="nieuwe-invoer" action="main_studenten.php" method="post">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
        <!-- KLASSEN       -->
        <select name="klas" id="klas">
            <?php
            foreach ($klassen as $id => $naam) {
            ?>
            <option value="<?php echo $id; ?>"><?php echo $naam; ?></option>
            <?php
            }
            ?>
        </select>
        <!-- SCRUMTEAMS       -->
        <select name="scrumteam" id="scrumteam">
            <?php
            foreach ($scrumteams as $stid) {
                ?>
                <option value="<?php echo $stid; ?>"><?php echo $stid; ?></option>
                <?php
            }
            ?>
        </select>
        <input type="text" name="ov" id="ov" placeholder="ov-nummer">
        <input type="text" name="voornaam" id="voornaam" placeholder="voornaam">
        <input type="text" name="tussenvoegsel" id="tussenvoegsel" placeholder="tussenvoegsel">
        <input type="text" name="achternaam" id="achternaam" placeholder="achternaam">
        <input id="submit" type="submit" name="submit" value="VOEG TOE">
    </form>

    <table id="maintable">
        <?php

        $query = "
            SELECT klassen.naam, s.id, s.ov, s.voornaam, s.tussenvoegsel, s.achternaam, s.gone, s.github, s.scrumteams_id 
            FROM klassen 
            INNER JOIN studenten s ON klassen.id = s.klas_id;
        ";
        $stmt = $mysqli->prepare($query) or die ('Error 7');
        $stmt->bind_result($klas, $id, $ov, $voornaam, $tussenvoegsel, $achternaam, $gone, $github, $scrumteamID) or die ('Error 8');
        $stmt->execute() or die ('Error 9');

        while ($row = $stmt->fetch()) {
            if ($gone) {
                echo '<tr class="studentrow" style="color: lightgray" id="' . $id . '">';
            } else {
                echo '<tr class="studentrow" id="' . $id . '">';
            }
            echo '<td>' . $ov . '</td>';
            echo '<td>Team ' . $scrumteamID . '</td>';
            echo '<td>' . $klas . '</td>';
            echo '<td>' . $voornaam . '</td>';
            echo '<td>' . $tussenvoegsel . '</td>';
            echo '<td>' . $achternaam . '</td>';
            echo '<td>' . $github . '</td>';
            echo '<td><a href="edit_student.php?id=' . $id . '"><i class="fas fa-edit"></i></a></td>';
            echo "</tr>\n";
        }
        $stmt->close();
        ?>
    </table>
</div>

<script src="javascript/verwijder_functies.js"></script>
<script src="javascript/remove_banner.js"></script>
<script src="javascript/newfunctions.js"></script>


</body>
</html>
