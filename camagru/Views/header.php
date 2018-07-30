<?php
  session_start();
?>

<head>
  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
  <link rel="stylesheet" href="http://localhost:8080/public/css/header.css">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
</head>

<body>
  <div class="row">
    <div class="header">
        <div class="cny_name col-xs-5">
          <a id="goindex" href="http://localhost:8080/index.php"><p>Camagru</p></a>
        </div>
        <?php
          if (!($_SESSION['user'])) {
        print (
              '
                <div class="auth pull-right col-xs-1 col-xs-offset-6">
                  <a href="http://localhost:8080/Views/signup.php"><button class="button pull-right">Sign up</button></a>
                  <a href="http://localhost:8080/Views/login.php"><button class="button pull-right">Log in</button></a>
                </div>
              '
              );
        } else {
        print (
              '<div class="profile col-xs-2" id="snap">
                  <a href="http://localhost:8080/Views/cam.php"><img class="snapicon" src="http://localhost:8080/public/ressources/camera.svg"/><p>Snap</p></a>
              </div>
              <div class="profile col-xs-1 col-xs-offset-4 pull-right">
                <div class="buttonand pull-right">
                  <button class="button" id="disco" type="submit" onclick="disco()">Disconnect</button>
                  <div class="info">
                    <a href="http://localhost:8080/Views/profile.php">
                      <img src="http://localhost:8080/public/ressources/user.svg"></img>
                      <p class="username" id="uname">' . $_SESSION['login'] . '</p>
                    </a>
                  </div>
                </div>
              </div>'
              );
        }
        ?>
    </div>
  </div>
<div class='row'><div class='span12'><hr class="stylehr"></div> </div>
</body>

<script src="../scripts/req_handler.js"></script>

<script>
  var path = window.location.origin + "/Controllers/Cont_disco.php";
  function disco() {
    request.post(path, null, function() {
      location.reload();
    },
    function() {
    })
  }
</script>