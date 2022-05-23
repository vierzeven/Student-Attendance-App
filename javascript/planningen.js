let cors = 'https://cors-anywhere.herokuapp.com/';
cors = "";
let todayDiv = document.getElementById('today');
let datum = document.getElementById('datum');
let telaat = document.getElementById('telaat');
let back = document.getElementById('back');
let forward = document.getElementById('forward');
let cohort = document.getElementById('cohort');
let loading = document.getElementById('loading');
let timeStep = 0;
getPlanning();

back.addEventListener('click', () => {
    startLoading();
    timeStep--;
    getPlanning();
});

forward.addEventListener('click', () => {
    startLoading();
    timeStep++;
    getPlanning();
});

cohort.addEventListener('change', () => {
    startLoading();
    getPlanning();
});

function getPlanning() {
    todayDiv.innerHTML = "";
    telaat.innerHTML = "";
    let url = 'https://ao.roc-dev.com/api?key=test&cohort=' + cohort.value;
    fetch(cors + url)
        .then(response => response.json())
        .then(data => render(data))
    ;
}


function render(data) {

    let today = new Date();
    today.setDate(today.getDate() + timeStep);
    let currentYear = today.getFullYear();
    let currentMonth = today.getMonth() + 1;
    let currentDay = today.getDate();
    let currentDate = currentDay + "-" + currentMonth + "-" + currentYear;
    datum.innerHTML = currentDate;

    for (var item in data) {

        // Get email and planningdates for each student
        let email = data[item]['email'];
        let planningdata = data[item]['planningdata'];

        // Check if the student forgot to plan at all
        let plannedToday = testForNotPlanning(planningdata, currentDate);
        if (!plannedToday) {
            // If not, add this name to the list of today
            let studentDiv = document.createElement('div');
            studentDiv.innerHTML = email;
            todayDiv.appendChild(studentDiv);
        }

        // Check if the student planned too late
        if (plannedToday) {
            let timeOfFirstPlanning = testForPlanningTooLate(planningdata, currentDate);
            if (timeOfFirstPlanning !== null) {
                let lateReport = document.createElement('div');
                lateReport.innerHTML = email + " " + timeOfFirstPlanning;
                telaat.appendChild(lateReport);
            }
        }


    }

    stopLoading();
}

function testForPlanningTooLate(planningdata, currentDate) {

    // Get all times this student planned today
    let times = [];
    for (var i = 0; i < planningdata.length; i++) {
        let planninggdatum = new Date(planningdata[i]);
        let year = planninggdatum.getFullYear();
        let month = planninggdatum.getMonth() + 1;
        let day = planninggdatum.getDate();
        let date = day + "-" + month + "-" + year;
        if (date === currentDate) {
            let hour = ("0" + planninggdatum.getHours()).slice(-2);
            let minutes = ("0" + planninggdatum.getMinutes()).slice(-2);
            let time = hour + ":" + minutes;
            times.push(time);
        }
    }
    times.reverse();

    // Check if the first planning was between 5AM and 9AM
    let validPlanning = false;
    if (times[0] < "09:00" && times[0] > "05:00") {
        validPlanning = true;
    }

    // If not, return the first time the student did plan
    if (!validPlanning) {
        return times[0];
    } else {
        return null;
    }

}

function testForNotPlanning(planningdata, currentDate) {

    let found = false;

    for (var i = 0; i < planningdata.length; i++) {
        let planninggdatum = new Date(planningdata[i]);
        let year = planninggdatum.getFullYear();
        let month = planninggdatum.getMonth() + 1;
        let day = planninggdatum.getDate();
        let date = day + "-" + month + "-" + year;
        if (date === currentDate) {
            found = true;
        }
    }
    return found;
}

function startLoading() {
    loading.style.display = "inline";
}

function stopLoading() {
    loading.style.display = "none";
}



