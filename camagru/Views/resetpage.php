<?php
  session_start();
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
      <input type="password" id="new_password" class="form-control" placeholder="New password" required autofocus>
      <input type="password" name="pwd_check" id="pwd_check" class="form-control" placeholder="Please confirm password" required>
      <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" id="submit" name="submit" onclick="updatepwd()" value="OK"/>Confirm password</button>
    </div>
  </div>
</div>
</body>

<script src="../scripts/req_handler.js"> </script>

<script>
  var input = document.getElementById("pwd_check");

  input.addEventListener("keyup", function(event) {
    event.preventDefault();
    if (event.keyCode === 13) {
    document.getElementById("submit").click();
    }
  })

  var data = [];
  data['uid'] = findGetParameter('0');
  data['login'] = findGetParameter('1');
  function updatepwd() {
    data['password'] = document.getElementById("new_password").value;
    var pwd_check = document.getElementById("pwd_check").value;
    var path = window.location.origin + "/Controllers/Cont_reset.php";
    if (!(pwd_check) || !(data['password']) || pwd_check != data['password']) {
      var newDiv = document.createElement('p');
      var newContent = document.createTextNode("Passwords don't match");
      var currentDiv = document.getElementById("new_password");

      newDiv.setAttribute('class', 'warning');
      newDiv.appendChild(newContent);
      document.getElementById("form").insertBefore(newDiv, currentDiv);
    } else if (data['password'] < 6) {
      var newDiv = document.createElement('p');
      var newContent = document.createTextNode("Password must be at least 6 characters");
      var currentDiv = document.getElementById("new_password");

      newDiv.setAttribute('class', 'warning');
      newDiv.appendChild(newContent);
      document.getElementById("form").insertBefore(newDiv, currentDiv);
    } else {
      request.post(path, data, function(response) {
        document.location.href = "http://localhost:8080/Views/login.php";
        },
        function (response) {
          document.location.href = "http://localhost:8080/views/resetpage.php";
        }
      )
    }
  }
  
  function findGetParameter(parameterName) {
    var result = null,
      tmp = [];
    location.search
      .substr(1)
      .split("&")
      .forEach(function (item) {
      tmp = item.split("=");
      if (tmp[0] === parameterName)
        result = decodeURIComponent(tmp[1]);
      });
    return result;
  }
</script>