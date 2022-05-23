let studentsearchbox = document.getElementById('studentsearchbox');

let binnenkomsten = document.getElementsByClassName('binnenkomst');
for (let i = 0; i < binnenkomsten.length; i++) {
    binnenkomsten[i].addEventListener('click', (e) => {
        let s_id = e.target.id.split('-')[1];
        if (e.target.innerText === "...") {
            save_time_of_entry(s_id);
        } else {
            delete_time_of_entry(s_id);
        }
    });
}

let vertrekken = document.getElementsByClassName('vertrek');
for (let i = 0; i < vertrekken.length; i++) {
    vertrekken[i].addEventListener('click', (e) => {
        let s_id = e.target.id.split('-')[1];
        if (e.target.innerText === "...") {
            save_time_of_leave(s_id);
        } else {
            delete_time_of_leave(s_id);
        }
    });
}

function delete_time_of_entry(s_id) {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            let binnenkomst = document.getElementById("binnenkomst-" + s_id);
            binnenkomst.innerHTML = '...';
            console.log(xhttp.responseText);
        }
    };
    xhttp.open("POST", "delete_time_of_entry.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("s_id=" + s_id);
}

function save_time_of_entry(s_id) {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            let binnenkomst = document.getElementById("binnenkomst-" + s_id);
            let tijdstip = new Date();
            let uren = tijdstip.getHours() < 10 ? "0" + tijdstip.getHours() : tijdstip.getHours();
            let minuten = tijdstip.getMinutes() < 10 ? "0" + tijdstip.getMinutes() : tijdstip.getMinutes();
            let seconden = tijdstip.getSeconds() < 10 ? "0" + tijdstip.getSeconds() : tijdstip.getSeconds();
            let tijd_string = uren + ":" + minuten + ":" + seconden;
            binnenkomst.innerHTML = tijd_string;
            let laatste = binnenkomst.parentElement.children[8];
            laatste.innerHTML = "0";
        }
    };
    xhttp.open("POST", "save_time_of_entry.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("s_id=" + s_id);
}

function delete_time_of_leave(s_id) {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            let vertrek = document.getElementById("vertrek-" + s_id);
            vertrek.innerHTML = '...';
            console.log(xhttp.responseText);
        }
    };
    xhttp.open("POST", "delete_time_of_leave.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("s_id=" + s_id);
}

function save_time_of_leave(s_id) {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            let vertrek = document.getElementById("vertrek-" + s_id);
            let tijdstip = new Date();
            let uren = tijdstip.getHours() < 10 ? "0" + tijdstip.getHours() : tijdstip.getHours();
            let minuten = tijdstip.getMinutes() < 10 ? "0" + tijdstip.getMinutes() : tijdstip.getMinutes();
            let seconden = tijdstip.getSeconds() < 10 ? "0" + tijdstip.getSeconds() : tijdstip.getSeconds();
            let tijd_string = uren + ":" + minuten + ":" + seconden;
            vertrek.innerHTML = tijd_string;
            let laatste = vertrek.parentElement.children[8];
            laatste.innerHTML = "0";
        }
    };
    xhttp.open("POST", "save_time_of_leave.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("s_id=" + s_id);
}

let clearicon = document.getElementById('clearicon');
let searchicon = document.getElementById('searchicon');
let searchbar = document.getElementById('searchbar').children[1];
let rows = document.getElementsByClassName('studentrow');

function filterStudents() {
    if (searchbar.value != "") {
        let term = searchbar.value.toLowerCase();
        clearicon.style.visibility = 'visible';
        searchicon.style.visibility = 'hidden';
        
        for (var i = 0 ; i < rows.length ; i++) {
            if (
                !rows[i].children[0].innerText.toLowerCase().includes(term)
                && !rows[i].children[1].innerText.toLowerCase().includes(term)
                && !rows[i].children[2].innerText.toLowerCase().includes(term)
                && !rows[i].children[3].innerText.toLowerCase().includes(term)
                && !rows[i].children[4].innerText.toLowerCase().includes(term)
                && !rows[i].children[5].innerText.toLowerCase().includes(term)) {
                rows[i].style.display = 'none';
            } else if (rows[i].children[0].style.display == "none") {
                rows[i].style.display = 'flex';
            } else {
                rows[i].style.display = 'table-row';
            }
        }
    } else {
        clearicon.style.visibility = 'hidden';
        searchicon.style.visibility = 'visible';
        for (var i = 0 ; i < rows.length ; i++) {
            console.log(rows[i].children[0].style.display);
            if (rows[i].children[0].style.display == "none") {
                rows[i].style.display = 'flex';
            } else {
                rows[i].style.display = 'table-row';
            }
        }
    }
}

function clearsearchbar() {
    searchbar.value = "";
    clearicon.style.visibility = 'hidden';
    searchicon.style.visibility = 'visible';
    for (var i = 0 ; i < rows.length ; i++) {
        console.log("display: " + rows[i].children[0]);
        if (rows[i].children[0].style.display == "none") {
            rows[i].style.display = 'flex';
        } else {
            rows[i].style.display = 'table-row';
        }
    }
    studentsearchbox.focus();
}

let navbar = document.getElementById('navbar');
navbar.addEventListener('click', () => {
    clearsearchbar();
    studentsearchbox.focus();
});