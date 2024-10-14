// Log download activity
function logDownloadActivity(fileName) {
    logActivity(`Downloaded archive file (${fileName})`);
}

// AJAX function to log activity
function logActivity(action, callback) {
    console.log("Logging activity:", action); // Debugging log

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "activity_log.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            try {
                const response = JSON.parse(xhr.responseText);
                if (response.status === "success") {
                    console.log('Activity logged successfully.');
                    if (callback) callback(); // Call the callback if provided
                } else {
                    console.error('Error logging activity:', response.message);
                }
            } catch (e) {
                console.error('Failed to parse response.', e);
            }
        }
    };

    // Send username and action to the server
    xhr.send("username=" + encodeURIComponent(username) + "&action=" + encodeURIComponent(action));
}
