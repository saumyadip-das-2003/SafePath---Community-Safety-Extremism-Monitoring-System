function voteIncident(incident_id, vote_type) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'citizen_dashboard.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                document.getElementById(`upvotes-${incident_id}`).innerText = response.upvotes;
                document.getElementById(`downvotes-${incident_id}`).innerText = response.downvotes;
            }
        }
    };
    xhr.send(`ajax=vote&incident_id=${incident_id}&vote_type=${vote_type}`);
}
