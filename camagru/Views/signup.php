<?php
  session_start();
  if (isset($_SESSION['user'])) {
    header('Location: http://localhost:8080/index.php');
    exit();
  }
?>

<head>
  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
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
      <input class="form-control" type="text" name="login" id="login" placeholder="Login" required>
      <input class="form-control" type="email" name="email" id="email" placeholder="Email" required>
      <input class="form-control" type="password" name="password" id="password" placeholder="Password" required>
      <input class="form-control" type="password" name="pwd_check" id="pwd_check" placeholder="Please confirm your password" required>
      <button class="btn btn-lg btn-primary btn-block btn-signin" id="submit" type="submit" onclick="validate()" value="OK">Sign in</button>
    </div>
  </div>
</div>
</body>

<script src="../scripts/req_handler.js"></script>

<script>
  
  var input = document.getElementById("pwd_check");

  input.addEventListener("keyup", function(event) {
    event.preventDefault();
    if (event.keyCode === 13) {
    document.getElementById("submit").click();
    }
  })


  function validate() {
    var elements = document.getElementsByClassName("warning");
    for(var i = 0; i < elements.length; i++) {
      elements[i].remove();
    }

    var data = [];
    var pwd_check = document.getElementById("pwd_check").value;

    data['login'] = document.getElementById("login").value;
    data['password'] = document.getElementById("password").value;
    data['email'] = document.getElementById("email").value;
    path = window.location.origin + "/Controllers/Cont_signup.php";
    // CHECK VALUES AND REMOVE 'required'
    if (!(pwd_check) || !(data['password']) || pwd_check != data['password']) {
      var newDiv = document.createElement('p');
      var newContent = document.createTextNode("Passwords don't match");
      var currentDiv = document.getElementById("login");

      newDiv.setAttribute('class', 'warning');
      newDiv.appendChild(newContent);
      document.getElementById("form").insertBefore(newDiv, currentDiv);
    } else if (data['login'].length < 4) {
      var newDiv = document.createElement('p');
      var newContent = document.createTextNode("Login must be at least 4 characters");
      var currentDiv = document.getElementById("login");

      newDiv.setAttribute('class', 'warning');
      newDiv.appendChild(newContent);
      document.getElementById("form").insertBefore(newDiv, currentDiv);
    } else if (data['password'].length < 6) {
      var newDiv = document.createElement('p');
      var newContent = document.createTextNode("Password must be at least 6 characters");
      var currentDiv = document.getElementById("login");

      newDiv.setAttribute('class', 'warning');
      newDiv.appendChild(newContent);
      document.getElementById("form").insertBefore(newDiv, currentDiv);
    } else if ((data['login']) && (data['email']) && (data['password'])) {
      request.post(path, data, function(response) {
        document.location.href = "http://localhost:8080/index.php";
        },
        function(response) {
          if (response == 409) {
            var newDiv = document.createElement('p');
            var newContent = document.createTextNode("Login already in use");
            var currentDiv = document.getElementById("login");

            newDiv.setAttribute('class', 'warning');
            newDiv.appendChild(newContent);
            document.getElementById("form").insertBefore(newDiv, currentDiv);
          } else if (response == 418) {
            var newDiv = document.createElement('p');
            var newContent = document.createTextNode("Email already in use");
            var currentDiv = document.getElementById("login");

            newDiv.setAttribute('class', 'warning');
            newDiv.appendChild(newContent);
            document.getElementById("form").insertBefore(newDiv, currentDiv);
          }
        }
      );
    }
  }
</script>
