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
      <input type="password" id="old_password" class="form-control" placeholder="Old password" required autofocus>
      <input type="password" id="new_password" class="form-control" placeholder="New password" required>
      <input type="password" id="pwd_check" class="form-control" placeholder="Confirm your password" required>
      <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" id="submit_reset" name="reset_password" onclick="updatepwd()" value="OK">Update password</button>
    </div>
  </div>
</div>
</body>

<script src="../scripts/req_handler.js"> </script>
<script>
  var data = [];
  data['uid'] = findGetParameter('0');
  data['login'] = findGetParameter('1');
  function updatepwd() {
    data['old_password'] = document.getElementById("old_password").value;
    data['password'] = document.getElementById("new_password").value;
    data['action'] = 'update';
    var pwd_check = document.getElementById("pwd_check").value;
    var path = window.location.origin + "/Controllers/Cont_reset.php";
    if (!(data['old_password']) || !(pwd_check) || !(data['password'])) {
      var newDiv = document.createElement('p');
      var newContent = document.createTextNode("Please fill up the info");
      var currentDiv = document.getElementById("old_password");

      newDiv.setAttribute('class', 'warning');
      newDiv.appendChild(newContent);
      document.getElementById("form").insertBefore(newDiv, currentDiv);
    } else if (data['password'].length < 6) {
      var newDiv = document.createElement('p');
      var newContent = document.createTextNode("Password must be at least 6 characters");
      var currentDiv = document.getElementById("old_password");

      newDiv.setAttribute('class', 'warning');
      newDiv.appendChild(newContent);
      document.getElementById("form").insertBefore(newDiv, currentDiv);
    } else if (pwd_check != data['password']) {
      var newDiv = document.createElement('p');
      var newContent = document.createTextNode("Passwords don't match");
      var currentDiv = document.getElementById("old_password");

      newDiv.setAttribute('class', 'warning');
      newDiv.appendChild(newContent);
      document.getElementById("form").insertBefore(newDiv, currentDiv);
    } else {
      request.post(path, data, function(response) {
        document.location.href = "http://localhost:8080/index.php";
        },
        function (response) {
          var newDiv = document.createElement('p');
          var newContent = document.createTextNode("Incorrect old password");
          var currentDiv = document.getElementById("old_password");

          newDiv.setAttribute('class', 'warning');
          newDiv.appendChild(newContent);
          document.getElementById("form").insertBefore(newDiv, currentDiv);
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