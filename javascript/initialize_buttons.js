const binnenButtons = document.getElementsByClassName('binnen');
const buitenButtons = document.getElementsByClassName('buiten');
const xhttp = new XMLHttpRequest();

zoek_aanwezige_studenten(binnenButtons, buitenButtons);

function zoek_aanwezige_studenten(binnenButtons, buitenButtons) {
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            if (xhttp.responseText !== 'Fail') {
                let aanwezige_studenten = xhttp.responseText;
                for (let i = 0; i < binnenButtons.length ; i++) {
                    if (aanwezige_studenten.indexOf(binnenButtons[i].id) !== -1) {
                        binnenButtons[i].style.background = "grey";
                        buitenButtons[i].style.background = "red";
                        buitenButtons[i].addEventListener('click', zet_buiten);

                    } else {
                        binnenButtons[i].style.background = "green";
                        binnenButtons[i].addEventListener('click', zet_binnen);
                        buitenButtons[i].style.background = "grey";
                    }
                }
            }
            zoek_vertrokken_studenten(binnenButtons, buitenButtons);
        }
    };
    xhttp.open("POST", "zoek_aanwezige_studenten.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}

function zoek_vertrokken_studenten(binnenButtons, buitenButtons) {
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            if (xhttp.responseText !== 'Fail') {
                let vertrokken_studenten = xhttp.responseText;
                for (let i = 0; i < buitenButtons.length ; i++) {
                    if (vertrokken_studenten.indexOf(buitenButtons[i].id.substr(6)) !== -1) {
                        buitenButtons[i].style.background = "grey";
                        buitenButtons[i].removeEventListener('click', zet_buiten);
                    }
                }
            } else {
                alert("Er is iets misgegaan. Probeer het opnieuw.");
            }
        }
    };
    xhttp.open("POST", "zoek_vertrokken_studenten.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}

function zet_binnen() {
    zet_binnenkomst_in_db(this.id);
}

function zet_buiten() {
    zet_vertrek_in_db(this.id);
}

function zet_binnenkomst_in_db(id) {
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            if (xhttp.responseText !== 'Fail') {
                let tijd = String(xhttp.responseText);
                console.log("Tijd: " + tijd);
                zet_binnenkomst_in_lijst(id, tijd);
            } else {
                alert("Er is iets misgegaan. Probeer het opnieuw.");
            }
        }
    };
    xhttp.open("POST", "zet_binnenkomst_in_db.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id=" + id);
}
function zet_vertrek_in_db(id) {
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            if (xhttp.responseText !== 'Fail') {
                let tijd = String(xhttp.responseText);
                zet_vertrek_in_lijst(id, tijd);
            } else {
                alert("Er is iets misgegaan. Probeer het opnieuw.");
            }
        }
    };
    xhttp.open("POST", "zet_vertrek_in_db.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id=" + id);
}

function zet_binnenkomst_in_lijst(id, tijd) {
    // Change binnen-button
    let binnen = document.getElementById(id);
    binnen.removeEventListener('click', zet_binnen);
    binnen.style.background = "grey";
    // Change buiten-button
    let buiten = document.getElementById("buiten" + id);
    buiten.style.background = "red";
    buiten.addEventListener('click', zet_buiten);
    // Get row for this student
    let row = document.getElementById("rij" + id);
    // Get field "BINNEN"
    let field = row.childNodes[6];
    field.innerHTML = tijd;
}

function zet_vertrek_in_lijst(id, tijd) {
    // Change buiten-button
    let buiten = document.getElementById(id);
    buiten.style.background = "grey";
    buiten.removeEventListener('click', zet_buiten);
    // Chop the word "buiten" off from the front of the id
    id = id.substr(6);
    // Get row for this student
    let row = document.getElementById("rij" + id);
    // Get field "BUITEN"
    let field = row.childNodes[7];
    field.innerHTML = tijd;
}




