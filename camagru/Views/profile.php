<?php
  session_start();
  if (!isset($_SESSION['user'])) {
    header('Location: http://localhost:8080/index.php');
    exit();
  }
?>
<head>
  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
  <link rel="stylesheet" href="../public/css/profile.css">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
</head>
<?php
  include $_SERVER['DOCUMENT_ROOT'] . '/Views/header.php';
?>
<body>
<div class="container-fluid main">
  <div class="row">
    <div class="profile_box col-xs-4 col-xs-offset-1" id="profile_box">
    <?php
      $isChecked = ($_SESSION['notif'] == true ? 'checked' : '');
      print('
              <img class="profile_pic" src="http://localhost:8080/public/ressources/user.svg"></img>
              <div class="row" id="loginrow">
                <p class="info col-xs-6 col-xs-offset-3" id="login">' . $_SESSION['login'] . '</p>
              </div>
              <div class="row" id="emailrow">
                <p class="info col-xs-6 col-xs-offset-3" id="email">' . $_SESSION['email'] . '</p>
              </div>
              <div class="row">
                <a class="col-xs-6 col-xs-offset-3" href="http://localhost:8080/views/update_password.php?0=' . $_SESSION['uid'] . '&1=' . $_SESSION['login'] . '"><p class="modify">Modify Password</p></a>
              </div>
              <p class="notif_text">Notification preference</p>
              <label class="switch">
                <input type="checkbox" id="checkbox"' . $isChecked . '>
                <span class="slider round"></span>
              </label>
              <div class="row">
                <input class="btn-primary submit col-xs-4 col-xs-offset-4" type="submit" id="submit">
              </div>
            ');
    ?>
    </div>
    <div class="pictures col-xs-9 pull-right" id="pictures">
      <div class="loader" id="loader">
        <div class="circle">
          <div class="inner-circle">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
  include $_SERVER['DOCUMENT_ROOT'] . '/Views/footer.php';
?>
</body>

<script src="../scripts/req_handler.js"></script>
<script>

var slider = document.getElementById('checkbox');
slider.addEventListener("change", function(e) {
  var data = [];
  data['notifs'] = e.target.checked;
  data['login'] = document.getElementById('uname').innerHTML;
  data['action'] = 'update';
  request.post(window.location.origin + "/Controllers/Cont_user.php", data, function(response) {
    }, function(response) {
      console.log('error');
    })
})


  var login = document.getElementById('login');
  var inputLogin = document.createElement('input');
  var email = document.getElementById('email');
  var inputEmail = document.createElement('input');
  var submit = document.getElementById('submit');
  var oldLogin = login.innerHTML;
  var oldEmail = email.innerHTML;

  inputLogin.setAttribute('spellcheck', 'false');
  inputLogin.setAttribute('type', 'text');
  inputLogin.setAttribute('id', 'loginupdate');
  inputLogin.setAttribute('class', 'form-control col-xs-6 col-xs-offset-4');
  inputLogin.value = oldLogin;

  inputEmail.setAttribute('spellcheck', 'false');
  inputEmail.setAttribute('type', 'text');
  inputEmail.setAttribute('id', 'emailupdate');
  inputEmail.setAttribute('class', 'form-control col-xs-6 col-xs-offset-4');
  inputEmail.value = oldEmail;

  login.addEventListener("click", function(e) {
    submit.style.display = "block";
    document.getElementById('loginrow').replaceChild(inputLogin, login);
  });
  email.addEventListener("click", function(e) {
    submit.style.display = "block";
    document.getElementById('emailrow').replaceChild(inputEmail, email);
  });

  var get = [];
  get['login'] = oldLogin;
  request.get(window.location.origin + "/Controllers/Cont_user.php", get, function(response) {
    var el = document.getElementById('loader');
    el.parentNode.removeChild(el);
    var i = 0;
    var pictures = JSON.parse(response);
      for (var item in pictures) {
        var mainDiv = document.createElement('div');
        var pDiv = document.createElement('div');
        var pLink = document.createElement('a');
        var pImg = document.createElement('img');
        var pDelete = document.createElement('img');

        if (i % 4 == 0) {
          var fRow = document.createElement('div');
          fRow.setAttribute('class', 'row row_pictures');
          document.getElementById('pictures').appendChild(fRow);
        }

        mainDiv.setAttribute('class', 'box_item col-xs-3');
        mainDiv.setAttribute('id', 'box' + pictures[item].picture_id);
        pDelete.setAttribute('id', pictures[item].picture_id);
        pDelete.src = 'http://localhost:8080/public/ressources/delete.svg';
        pLink.href = 'http://localhost:8080/Views/picture.php?id=' + pictures[item].picture_id + '&author=' + pictures[item].author_login;
        pDiv.setAttribute('class', 'pic_item');
        pImg.setAttribute('class', 'picture');
        pImg.src = 'data:image/png;base64,' + pictures[item].final_encode64;
        pDelete.setAttribute('class', 'delete_pic');

        pDiv.appendChild(pLink);
        pLink.appendChild(pImg);
        mainDiv.appendChild(pDelete);
        mainDiv.appendChild(pDiv);

        pDelete.addEventListener("click", function(e) {
          var el = document.getElementById('box' + this.getAttribute('id'))
          var data = [];
          data['action'] = 'delete';
          data['picture_id'] = this.getAttribute('id');
          request.post('http://localhost:8080/Controllers/Cont_user.php', data, function(response) {
              el.parentNode.removeChild(el);
            }, function(response) {
              console.log('error');
            }
          )
        })
        // document.getElementById('pictures').appendChild(mainDiv);
        var toPic = document.getElementsByClassName('row row_pictures');
        toPic[toPic.length - 1].appendChild(mainDiv);
        i++;
      }
    }, function(response) {
      console.log('error');
    }
  )

  /*
    On click actions
  */
  submit.addEventListener("click", function(e) {
    /*
      Updating at least login
    */
    var elements = document.getElementsByClassName("warning");
    for(var i = 0; i < elements.length; i++) {
      elements[i].remove();
    }

    if (document.getElementById('loginupdate') && window.oldLogin != document.getElementById('loginupdate').value) { // if ok
      var data = [];
      data['oldlogin'] = window.oldLogin;
      data['newlogin'] = document.getElementById('loginupdate').value;
      request.post(window.location.origin + "/Controllers/Cont_user.php", data, function(response) {
        if (document.getElementById('emailupdate') && window.oldemail != document.getElementById('emailupdate').value) {
          window.oldLogin = data['newlogin'];
          var params = [];
          params['oldemail'] = window.oldEmail;
          params['newemail'] = document.getElementById('emailupdate').value;

          request.post(window.location.origin + "/Controllers/Cont_user.php", params, function(response) {
            }, function(response) {
              if (response == 418) {
                var newDiv = document.createElement('p');
                var newContent = document.createTextNode("Email already taken");
                var currentDiv = document.getElementById("loginrow");

                newDiv.setAttribute('class', 'warning');
                newDiv.appendChild(newContent);
                document.getElementById("profile_box").insertBefore(newDiv, currentDiv);
              }
            }
          )}
        }, function(response) {
          if (response == 409) {
            var newDiv = document.createElement('p');
            var newContent = document.createTextNode("Login already taken");
            var currentDiv = document.getElementById("loginrow");
            
            newDiv.setAttribute('class', 'warning');
            newDiv.appendChild(newContent);
            document.getElementById("profile_box").insertBefore(newDiv, currentDiv);
          }
        }
        // location.reload();
      )
    /*
      updating only email
    */
    } else if (document.getElementById('emailupdate') && window.oldemail != document.getElementById('emailupdate').value) {
      var params = [];
      params['oldemail'] = window.oldEmail;
      params['newemail'] = document.getElementById('emailupdate').value;
      request.post(window.location.origin + "/Controllers/Cont_user.php", params, function(response) {
            location.reload();
        }, function(response) {
          if (response == 418)
            var newDiv = document.createElement('p');
            var newContent = document.createTextNode("Email already taken");
            var currentDiv = document.getElementById("loginrow");

            newDiv.setAttribute('class', 'warning');
            newDiv.appendChild(newContent);
            document.getElementById("profile_box").insertBefore(newDiv, currentDiv);
          }
      )
    }
  })

  /*
    Cancel modif on escape
  */
  window.addEventListener("keydown", function(e) {
    if (e.defaultPrevented) {
      return ;
    }
    if (e.key == "Escape") {
      if (document.getElementById('loginupdate')) {
        var login = document.createElement('p');

        login.setAttribute('id', 'login');
        login.innerHTML = window.oldLogin;
        login.addEventListener("click", function(e) {
          submit.style.display = "block";
          document.getElementById('loginrow').replaceChild(inputLogin, login);
        });
        document.getElementById('loginrow').replaceChild(login, document.getElementById('loginupdate'));
      }
      if (document.getElementById('emailupdate')) {
        var email = document.createElement('p');

        email.setAttribute('id', 'email')
        email.innerHTML = window.oldEmail;
        email.addEventListener("click", function(e) {
          submit.style.display = "block";
          document.getElementById('emailrow').replaceChild(inputEmail, email);
        });
        document.getElementById('emailrow').replaceChild(email, document.getElementById('emailupdate'));
      }
      document.getElementById('submit').style.display = "none";
    }
  })
</script>