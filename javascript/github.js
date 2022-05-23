let githubs = document.getElementsByClassName('github');
for (var i = 0; i < githubs.length; i++) {
    if (githubs[i].hasChildNodes()) {
        var href = githubs[i].children[0].getAttribute('href');
        var github_username = href.split('.com/')[1];
        let url = 'https://api.github.com/users/' + github_username + '/events?per_page=100';
        let headers = {
            headers: {
                authorization: "token 4fc26ee30592f3cc516f0ffb88669c788a638bf3",
                "Accept": "application/vnd.github.cloak-preview",
                'User-Agent': 'request'
            }
        }
        let today = new Date();
        let formatted = today.getFullYear() + "-" + ("0" + (today.getMonth() + 1)).substr(-2, 2) + "-" + ("0" + today.getDate()).substr(-2, 2);
        getEvents(githubs[i].parentElement, githubs[i]);

        async function getEvents(row, cell) {
            let start_date = formatted;
            let end_date = formatted;
            let response = await fetch(url, headers);
            let result = await response.json();
            let count = 0;
            result.forEach(element => {
                let date = element.created_at.substr(0, 10);
                // if (date >= start_date && date <= end_date && element.type == 'PushEvent') {
                if (date >= start_date && date <= end_date) {
                    count++;
                }
            });
            if (count != 0) {
                row.className += " push";
            }
            cell.innerHTML += '<span class="times">' + count + ' x</span>';
        }
    }
}