<?php

// Start session, connect to DB, check if user is logged in, load head of page, set timezone, create new CSRF token
require('initialize.php');
require('current_timestamp.php');
// header('Refresh: 300');

?>

<div class="content">

    <div class="planningen">

        <img id="loading" src="images/loading.gif" alt="loading">
        
        <h2 id="datum"></h2>

        <button id="back">TERUG</button>
        <button id="forward">VOORUIT</button>
        <select name="cohort" id="cohort">
            <option value="2021">2021</option>
            <option value="2020">2020</option>
            <option value="2019">2019</option>
            <option value="2018">2018</option>
            <option value="2017">2017</option>
        </select>

        <h2>Geen planning ingevuld</h2>
        <div id="today"></div>

        <h2>Planning niet tussen 5:00 en 9:00 ingevuld</h2>
        <div id="telaat"></div>
    </div>

</div>
<script src="javascript/newfunctions.js"></script>
<script src="javascript/planningen.js"></script>

</body>

</html>