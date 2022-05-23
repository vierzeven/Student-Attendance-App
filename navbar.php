<nav id="navbar">
    <div id="searchbar">
        <a href="main_presenties.php">
            <svg id="rocdevlogo" viewBox="0 0 100 100">
                <path d="M50,50 v-50 A50,50 0 0,0 0,50" style="fill: #5273B7; fill-opacity: 1" />
                <path d="M50,50 v-50 A50,50 0 0,1 100,50" style="fill: #E0342F; fill-opacity: 1" />
                <path d="M50,50 v50 A50,50 0 0,0 100,50" style="fill: #F8C045; fill-opacity: 1" />
                <path d="M50,50 v50 A50,50 0 0,1 0,50" style="fill: #51AE44; fill-opacity: 1" />
                <path d="M50,0 v100" style="stroke-width: 5" class="gap" />
                <path d="M0,50 h100" style="stroke-width: 5" class="gap" />
            </svg>
        </a>

        <!-- "Zoek studenten" laten verschijnen op presentiepagina -->
        <?php echo $url == 'main_presenties.php' ? '<input id="studentsearchbox" type="text" placeholder="Zoek student..." oninput="filterStudents()">' : null ?>
        <?php echo $url == 'main_presenties.php' ? '<i id="searchicon" class="fas fa-search" onclick="clearsearchbar()" style="visibility: visible"></i>' : null ?>
        <?php echo $url == 'main_presenties.php' ? '<i id="clearicon" class="fas fa-times-circle" onclick="clearsearchbar()" style="visibility: hidden"></i>' : null ?>

        <!-- "Zoek studenten" laten verschijnen op studentenpagina -->
        <?php echo $url == 'main_studenten.php' ? '<input id="studentsearchbox" type="text" placeholder="Zoek student..." oninput="filterStudents()">' : null ?>
        <?php echo $url == 'main_studenten.php' ? '<i id="searchicon" class="fas fa-search" onclick="clearsearchbar()" style="visibility: visible"></i>' : null ?>
        <?php echo $url == 'main_studenten.php' ? '<i id="clearicon" class="fas fa-times-circle" onclick="clearsearchbar()" style="visibility: hidden"></i>' : null ?>


    </div>
    <div id="buttons">


        <a <?php echo $url == 'main_presenties.php' ? 'id="selected"' : null ?> href="main_presenties.php">PRESENTIES INVOEREN</a>
        <a <?php echo $url == 'main_absenties.php' ? 'id="selected"' : null ?> href="main_absenties.php">ABSENTIES BEKIJKEN</a>
        <a <?php echo $url == 'main_absenties_week.php' ? 'id="selected"' : null ?> href="main_absenties_week.php">WEEKOVERZICHT</a>
        <a <?php echo $url == 'main_klassen.php' ? 'id="selected"' : null ?> href="main_klassen.php">KLASSEN BEWERKEN</a>
        <a <?php echo $url == 'main_studenten.php' ? 'id="selected"' : null ?> href="main_studenten.php">STUDENTEN BEWERKEN</a>
        <a <?php echo $url == 'main_scrumteams.php' ? 'id="selected"' : null ?> href="main_scrumteams.php">SCRUMTEAMS BEKIJKEN</a>
        <a <?php echo $url == 'main_github_trouble.php' ? 'id="selected"' : null ?> href="main_github_trouble.php?cohort=1">GITHUB COMMITS</a>
<!--        <a --><?php //echo $url == 'main_lang_afwezig.php' ? 'id="selected"' : null ?><!-- href="main_lang_afwezig.php">LANG AFWEZIG</a>-->
        <a <?php echo $url == 'main_planningen.php' ? 'id="selected"' : null ?> href="main_planningen.php">PLANNINGEN</a>
        <a href="../intakes/admin/home.php">INTAKES</a>


        <a id="logout" href="uitlogpoort.php">UITLOGGEN</a>
    </div>
</nav>