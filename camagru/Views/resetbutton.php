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
      <input type="text" id="login" class="form-control" placeholder="Login" required autofocus>
      <input type="email" id="email" class="form-control" placeholder="Email" required>
      <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit" id="submit_reset" name="reset_password" onclick="submit_reset()" value="OK">Ask for new password</button>
    </div>
  </div>
</div>
</body>

<script src="../scripts/req_handler.js"> </script>

<script>
function submit_reset() {
  var data = [];
  data['login'] = document.getElementById("login").value;
  data['email'] = document.getElementById("email").value;
  data['action'] = 'reset';
  path = window.location.origin + "/Controllers/Cont_reset.php";
  if (!data['login'] || !data['email']) {
    var newDiv = document.createElement('p');
    var newContent = document.createTextNode("Please fill up the info");
    var currentDiv = document.getElementById("login");

    newDiv.setAttribute('class', 'warning');
    newDiv.appendChild(newContent);
    document.getElementById("form").insertBefore(newDiv, currentDiv);
  }
  if ((data['login']) && (data['email'])) {
    request.post(path, data, function(response) {
        var newDiv = document.createElement('p');
        var newContent = document.createTextNode("Success! Check your emails. You will be redirected soon");
        var currentDiv = document.getElementById("login");

        newDiv.setAttribute('class', 'warning');
        newDiv.setAttribute('id', 'success');
        newDiv.appendChild(newContent);
        document.getElementById("form").insertBefore(newDiv, currentDiv);

        setTimeout(function() {
            document.location.href = "http://localhost:8080/index.php";
          }, 3000)
      },
      function(response) {
        if (response == 409) {
          var newDiv = document.createElement('p');
          var newContent = document.createTextNode("Login and email don't match");
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