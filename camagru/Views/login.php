<?php
  session_start();
  if (isset($_SESSION['user'])) {
    header('Location: http://localhost:8080/index.php');
    exit();
  }
?>

<head>
  <link rel="stylesheet" href="../public/css/signup.css">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
</head>

<body>
<div class="container">
  <div class="card card-container">
    <p class="logo">Camagru</p>
    <p id="profile-name" class="profile-name-card"></p>
    <div class="form-signin" id="form">
        <input type="text" id="login" class="form-control" placeholder="Login" required autofocus>
        <input type="password" id="password" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" id="submit" onclick="log()">Log in</button>
    </div>
    <a href="http://localhost:8080/Views/resetbutton.php" class="forgot-password">
        Password forgotten ?
    </a>
    </div>
</div>
</body>

<script src="../scripts/req_handler.js"></script>

<script>

var input = document.getElementById("password");

  input.addEventListener("keyup", function(event) {
    event.preventDefault();
    if (event.keyCode === 13) {
    document.getElementById("submit").click();
    }
  })

  function log() {
    var elements = document.getElementsByClassName("warning");
    for(var i = 0; i < elements.length; i++) {
      elements[i].remove();
    }

    var data = [];
    data['login'] = document.getElementById("login").value;
    data['password'] = document.getElementById("password").value;
    path = window.location.origin + "/Controllers/Cont_login.php";
    if (!(data['login']) || !(data['password'])) {
      var newDiv = document.createElement('p');
      var newContent = document.createTextNode("Please fill up the info");
      var currentDiv = document.getElementById("login");

      newDiv.setAttribute('class', 'warning');
      newDiv.appendChild(newContent);
      document.getElementById("form").insertBefore(newDiv, currentDiv);
    } else {
      request.post(path, data, function(response) {
        document.location.href = "http://localhost:8080/index.php";
      },
      function(response) {
        if (response == 409) {
          var newDiv = document.createElement('p');
          var newContent = document.createTextNode("Login and password don't match");
          var currentDiv = document.getElementById("login");

          newDiv.setAttribute('class', 'warning');
          newDiv.appendChild(newContent);
          document.getElementById("form").insertBefore(newDiv, currentDiv);
        } else if (response == 418) {
          var newDiv = document.createElement('p');
          var newContent = document.createTextNode("Login not found");
          var currentDiv = document.getElementById("login");

          newDiv.setAttribute('class', 'warning');
          newDiv.appendChild(newContent);
          document.getElementById("form").insertBefore(newDiv, currentDiv);
        }
      })
    }
  }
</script>