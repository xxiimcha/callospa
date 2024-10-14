 // Periodically check session validity every 30 seconds
  setInterval(function () {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'SessionValidity.php', true); // Call a script to check session validity
    xhr.onload = function () {
      if (xhr.status === 200) {
        if (xhr.responseText === 'invalid') {
          // Redirect to login page if session is invalid
          window.location.href = 'AdminLogin.php';
        }
      }
    };
    xhr.send();
  }, 5000);


 