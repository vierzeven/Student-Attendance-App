<?php

require('initialize.php');

if (isset($_POST['klas']) && !empty($_POST['klas']) && isset($_POST['submit']) && $_POST['submit'] === 'VOEG TOE' && isset($_POST['csrf_token']) && $_POST['csrf_token'] == $_SESSION['csrf_token']) {
    $naam = strtoupper($_POST['klas']);
    $query = "INSERT INTO klassen VALUES (0, ?)";
    $stmt = $mysqli->prepare($query) or die ('Error 1');
    $stmt->bind_param('s',$naam) or die ('Error 2');
    $stmt->execute() or die ('Error 3');
    $stmt->close();
}

// Set new CSRF-token
$csrf_token = hash('sha512', time());
$_SESSION['csrf_token'] = $csrf_token;

?>

<div class="content">
    <form class="nieuwe-invoer" action="main_klassen.php" method="post">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
        <input type="text" name="klas" id="klas" placeholder="Naam klas"></label>
        <input id="submit" type="submit" name="submit" value="VOEG TOE">
    </form>

    <table id="klassen">
        <?php

        $query = "SELECT * FROM klassen ORDER BY naam ASC";
        $stmt = $mysqli->prepare($query) or die ('Error 4');
        $stmt->bind_result($k_id, $k_naam) or die ('Error 5');
        $stmt->execute() or die ('Error 6');
        while ($row = $stmt->fetch()) {
            echo '<tr id="' . $k_id . '">';
            echo '<td class="klassennaam">' . $k_naam . '</td>';
            echo '<td><i class="fas fa-trash-alt" onclick="verwijder_klas_uit_db(' . $k_id . ')"></i></td>';
            echo "</tr>\n";
        }
        $stmt->close();
        ?>
    </table>
</div>

<script src="javascript/verwijder_functies.js"></script>
<script src="javascript/remove_banner.js"></script>

</body>
</html>
