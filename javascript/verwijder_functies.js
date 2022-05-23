function verwijder_klas_uit_db(id) {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            console.log(xhttp.responseText);
            if (xhttp.responseText !== 'Fail') {
                verwijder_klas_uit_lijst(id);
            } else {
                alert("Deze klas kun je niet verwijderen, omdat er nog studenten in zitten.");
            }
        }
    };
    xhttp.open("POST", "verwijder_klas_uit_db.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id=" + id);
}

function verwijder_klas_uit_lijst(id) {
    let regel = document.getElementById(id);
    regel.parentNode.removeChild(regel);
}

function verwijder_student_uit_db(id) {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            console.log(this.responseText);
            if (xhttp.responseText !== 'Fail') {
                verwijder_student_uit_lijst(id);
            }
        }
    };
    xhttp.open("POST", "verwijder_student_uit_db.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id=" + id);
}

function verwijder_student_uit_lijst(id) {
    alert(id);
    let regel = document.getElementById(id);
    regel.parentElement.removeChild(regel);
}