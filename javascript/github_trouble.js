let github_links = document.getElementsByClassName('github');
checkGithub();

function checkGithub() {
    for (var i = 0; i < github_links.length; i++) {
        // If there is an actual link to Github...
        if (github_links[i].hasChildNodes()) {
            let github_link = github_links[i];
            // Extract the href attribute...
            var href = github_link.children[0].getAttribute('href');
            // Distill the Github username from it...
            var github_username = href.split('.com/')[1];
            // And use it to create a URL to the Github API
            let url = 'https://api.github.com/search/commits?q=author:' + github_username + '&per_page=1';
            // Include headers
            let headers = {
                headers: {
                    authorization: "token 4fc26ee30592f3cc516f0ffb88669c788a638bf3",
                    "Accept": "application/vnd.github.cloak-preview"
                }
            }
            // Fetch the data
            fetch(url, headers)
                .then(response => response.json())
                .then(data => place(github_link.parentElement, data['total_count']));

        }
    }
}

function place(row, total_count) {
    if (total_count == null || total_count === 0 || total_count === undefined) {
        row.style.background = "gold";
    }
    // Place the result (the total number of commits) in the row
    let github_link = row.lastChild;
    row.removeChild(row.lastChild);
    let total_count_div = document.createElement('td');
    total_count_div.innerHTML = total_count + " commits";
    row.appendChild(total_count_div);
    row.appendChild(github_link);
    row.style.borderBottom = "1px solid grey";
    if (total_count < 25) {
        row.style.background = "#ff5d5d";
    }
}

