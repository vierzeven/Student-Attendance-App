<?php

require('initialize.php');

$id = (int) $_GET['id'];

$query = "
SELECT s.id AS id, s.voornaam, s.tussenvoegsel, s.achternaam, klassen.naam, s.ov, s.github, s.gone, s2.id, c.voornaam AS klas 
FROM studenten s
INNER JOIN klassen ON s.klas_id = klassen.id 
INNER JOIN scrumteams s2 on s.scrumteams_id = s2.id
INNER JOIN coaches c on s2.coach_id = c.id
WHERE s.id = ?
";
$stmt = $mysqli->prepare($query) or die ('Error 1');
$stmt->bind_param('i',$id) or die ('Error 2');
$stmt->bind_result($id, $voornaam, $tussenvoegsel, $achternaam, $klas, $ov, $github, $gone, $scrumteamID, $coachVoornaam) or die ('Error 3');
$stmt->execute() or die ('Error 4');
$stmt->fetch();
$stmt->close();

?>

<div class="content">
<table id="maintable">
    <form action="save_student.php" method="post">
        <tr id="sorteerknoppen">
            <td></td>
            <td></td>
        </tr>
        <tr style="display: none">
            <td>ID:</td>
            <td><?php echo $id; ?></td>
            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
        </tr>
        <tr>
            <td class="omschrijving">
                <label for="ov">OV-nummer:</label>
            </td>
            <td>
                <input type="text" name="ov" id="ov" value="<?php echo $ov; ?>">
            </td>
        </tr>
        <tr>
            <td class="omschrijving">
                <label for="voornaam">Voornaam:</label>
            </td>
            <td>
                <input type="text" name="voornaam" id="voornaam" value="<?php echo $voornaam; ?>">
            </td>
        </tr>
        <tr>
            <td class="omschrijving">
                <label for="tussenvoegsel">Tussenvoegsel:</label>
            </td>
            <td>
                <input type="text" name="tussenvoegsel" id="tussenvoegsel" value="<?php echo $tussenvoegsel; ?>">
            </td>
        </tr>
        <tr>
            <td class="omschrijving">
                <label for="achternaam">Achternaam:</label>
            </td>
            <td>
                <input type="text" name="achternaam" id="achternaam" value="<?php echo $achternaam; ?>">
            </td>
        </tr>

        <!-- KLAS -->
        <tr>
            <td class="omschrijving">
                <label for="klas">Klas:</label>
            </td>
            <td>
                <select name="klas" id="klas">
                <?php
                $query = "SELECT id, naam FROM klassen";
                $stmt = $mysqli->prepare($query) or die ('Error 5');
                $stmt->bind_result($id, $naam) or die ('Error 6');
                $stmt->execute() or die ('Error 7');
                while ($row = $stmt->fetch()) {
                    if ($naam == $klas) {
                        echo '<option value="' . $id . '" selected>' . $naam . '</option>';
                    } else {
                        echo '<option value="' . $id . '">' . $naam . '</option>';
                    }
                }
                ?>
                </select>
            </td>
        </tr>

        <!-- SCRUMTEAM -->
        <tr>
            <td class="omschrijving">
                <label for="scrumteam">Scrumteam:</label>
            </td>
            <td>
                <select name="scrumteam" id="scrumteam">
                    <?php
                    $query = "SELECT id FROM scrumteams";
                    $stmt = $mysqli->prepare($query) or die ('Error 5');
                    $stmt->bind_result($teamID) or die ('Error 6');
                    $stmt->execute() or die ('Error 7');
                    while ($row = $stmt->fetch()) {
                        if ($scrumteamID == $teamID) {
                            echo '<option value="' . $teamID . '" selected>' . $teamID . '</option>';
                        } else {
                            echo '<option value="' . $teamID . '">' . $teamID . '</option>';
                        }
                    }
                    ?>
                </select>
            </td>
        </tr>

        <!-- COACH -->
        <tr>
            <td class="omschrijving">
                <label for="coach">Coach:</label>
            </td>
            <td>
                <?php echo ucfirst($coachVoornaam); ?>
            </td>
        </tr>


        <!-- GITHUB -->
        <tr>
            <td class="omschrijving">
                <label for="github">Github username:</label>
            </td>
            <td>
                <input type="text" name="github" id="github" value="<?php echo $github; ?>">
            </td>
        </tr>

        <!-- GONE -->
        <tr>
            <td class="omschrijving">
                <label for="gone">Niet in de klas:</label>
            </td>
            <td>
                <?php
                if ($gone == 1) {
                    echo '<input type="hidden" name="gone" id="gone" value="0">';
                    echo '<input type="checkbox" checked name="gone" id="gone" value="1">';
                } else {
                    echo '<input type="hidden" name="gone" id="gone" value="0">';
                    echo '<input type="checkbox" name="gone" id="gone" value="1">';
                }
                ?>
            </td>
        </tr>
        <tr>
            <td>
                <label for="submit"></label>
            </td>
            <td>
                <input type="submit" name="submit" id="submit" value="SAVE">
                <i class="fas fa-save"></i>
            </td>
        </tr>
    </form>
</table>

</div>