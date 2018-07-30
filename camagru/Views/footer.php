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

<?php
  if (isset($_SESSION['user']) && $_SESSION['valid_account'] == false) {
    print(
      '
      <div class="container-fluid footer">
        <div class="row"><div class="span12"><hr class="stylehr" id="footerhr"></div></div>
        <div class="row">
          <div class="col-xs-12 validate">
            <p>You have 14 days to validate your account</p>
          </div>
        </div>
      </div>
      '
    );
  }
?>
</body>

