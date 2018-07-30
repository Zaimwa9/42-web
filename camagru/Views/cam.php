<?php
session_start();
if (!($_SESSION['user'])) {
  header('Location: http://localhost:8080/index.php');
  exit();
}
include $_SERVER['DOCUMENT_ROOT'] . '/Views/header.php';
?>

<head>
  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
  <link rel="stylesheet" href="http://localhost:8080/public/css/cam.css">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
</head>


<body>

<div class="container-fluid">
  <div class="row">

  <div class="snapshot col-xs-4">
    <div class="background">
      <video id="video"></video>
    </div>

    <div class="foreground">
      <img class="img" id="img" src="" filter=""></img>
    </div>
  </div>

  <div class="col-xs-1 col-xs-offset-2">
    <button class="btn btn-primary" id="startbutton">Snap !</button>
  </div>
      
    <div class="select col-lg-1 hidden-md hidden-sm hidden-xs">
      <div class="size_selector" id="ssizes">
        <p>Select size</p>
        <input type="radio" name="size" value="small" id="small">
        <label for="small">S</label><br>
        <input type="radio" name="size" value="medium" id="medium">
        <label for="medium">M</label><br>
        <input type="radio" name="size" value="large" id="large">
        <label for="large">XL</label><br>
      </div>
    </div>
      <div class="select col-xs-2 hidden-xs" id="sfilters">
        <p>Choose a filter and place it wherever you want!</p>
        <div class="row">
          <div class="filter_selector col-xs-12 col-md-12" id="filter_selector">
          </div>
        </div>

        <div class="row">
          <div class="upload_section">
            <form method="post" action="http://localhost:8080/Controllers/Cont_img.php" enctype="multipart/form-data">
              <p style="text-align: center">Or upload a picture and see what happens next!</p>
              <input class="upload" type="file" name="img" required></input><br>
              <input class="btn btn-primary" type="submit" name="submit" id="uploadsubmit"></input>
            </form>
          </div>
        </div>

      </div>

    </div>
  </div>

  <!-- PHOTOS POSTEES -->
  <div class="row">
    <div class="past_pic col-xs-9 col-xs-offset-2">
      <div class="pictures" id="pictures">
        <div class="loader" id="loader"></div>
      </div>
    </div>
  </div>
  <!-- Fin du conteneur juste en dessous -->
</div>

  <canvas id="canvas"></canvas>
</body>

<script src="../scripts/req_handler.js"></script>

<script>

/*
  Drag and drop of picture
*/

var posXfilter = 0;
var posYfilter = 0;
var img = document.getElementById('img')
var cam = document.getElementById('video');
var camWidth = 320;
var camHeight = 240;
var imgHeight = cam.clientHeight;
var imgWidth = img.clientWidth;
var imgHeight = img.clientHeight;

dragElement(img);

function dragElement(elmnt) {
  var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
  if (document.getElementById(elmnt.id)) {
    document.getElementById(elmnt.id).onmousedown = dragMouseDown;
  } else {
    elmnt.onmousedown = dragMouseDown;
  }

  function dragMouseDown(e) {
    e = e || window.event;
    // get the mouse cursor position at startup:
    pos3 = e.clientX;
    pos4 = e.clientY;
    document.onmouseup = closeDragElement;
    // call a function whenever the cursor moves:
    document.onmousemove = elementDrag;
  }

  function elementDrag(e) {
    e = e || window.event;
    // calculate the new cursor position:
    pos1 = pos3 - e.clientX;
    pos2 = pos4 - e.clientY;
    pos3 = e.clientX;
    pos4 = e.clientY;
    window.imgHeight = document.getElementById('img').clientHeight;
    window.imgWidth = document.getElementById('img').clientWidth;
    // set the element's new position: // Ici pour gerer l'endroit max
    elmnt.style.top = (elmnt.offsetTop - pos2 > cam.clientHeight - window.imgHeight ? cam.clientHeight - window.imgHeight : (elmnt.offsetTop - pos2 < 0 ? 0 : elmnt.offsetTop - pos2)) + "px";
    window.posYfilter = elmnt.style.top;
    elmnt.style.left = (elmnt.offsetLeft - pos1 > cam.clientWidth - window.imgWidth ? cam.clientWidth - window.imgWidth : (elmnt.offsetLeft - pos1 < 0 ? 0 : elmnt.offsetLeft - pos1)) + "px";
    window.posXfilter = elmnt.style.left;
  }

  function closeDragElement() {
    /* stop moving when mouse button is released:*/
    document.onmouseup = null;
    document.onmousemove = null;
  }
}

/*
  Get filters
*/

var filter = [];
filter['action'] = 'fetch';
request.get('http://localhost:8080/Controllers/Cont_img.php', filter, function(response) {
    var filters = JSON.parse(response);
    var fDiv = document.getElementById('filter_selector');
    var i = 0;
    filters.forEach(function(filter) {
      if (i % 3 == 0) {
        var fRow = document.createElement('div');
        fRow.setAttribute('class', 'row row_filters');
        fDiv.appendChild(fRow);
      }
      var fBox = document.createElement('div');
      var fInput = document.createElement('input');
      var fLabel = document.createElement('label');
      var fImg = document.createElement('img');

      fBox.setAttribute('class', 'filter_box col-xs-4');
      fInput.setAttribute('id', 'inp' + filter.filter_name);
      fInput.setAttribute('type', 'radio');
      fInput.setAttribute('value', filter.filter_name);
      fInput.setAttribute('name', 'filter');

      fInput.addEventListener("change", function(e) {
        var mainImg = document.getElementById('img');
        mainImg.src = "http://localhost:8080/img/filter/" + filter.filter_name;
        img.style.display = 'flex';
        mainImg.setAttribute('filter_name', filter.filter_name);
        window.imgWidth = mainImg.clientWidth;
        window.imgHeight = mainImg.clientHeight;
      })
      fLabel.setAttribute('for', filter.filter_name);
      
      fImg.setAttribute('id', 'sm' + filter.filter_name);
      fImg.src = 'data:image/png;base64,' + filter.encode64;
      fImg.style.maxWidth = '40px';
      fBox.appendChild(fInput);
      fBox.appendChild(fLabel);
      fBox.appendChild(fImg);
      var toApp = document.getElementsByClassName('row row_filters');
      toApp[toApp.length - 1].appendChild(fBox);

      i++;
    })
  }, function (response) {
  }
)
/*
  Recuperation des images
*/
  var get = [];
  get['login'] = document.getElementById('uname').innerHTML;
  request.get(window.location.origin + "/Controllers/Cont_user.php", get, function(response) {
    var el = document.getElementById('loader');
    el.parentNode.removeChild(el);
    var pictures = JSON.parse(response);
    var picDiv = document.getElementById('pictures');
    var i = 0;
      for (var item in pictures) {
        if (i % 6 == 0) {
          var picRow = document.createElement('div');
          picRow.setAttribute('class', 'row row_pictures');
          picDiv.appendChild(picRow);
        }

        var mainDiv = document.createElement('div');
        var pDiv = document.createElement('div');
        var pLink = document.createElement('a');
        var pImg = document.createElement('img');
        var pDelete = document.createElement('img');

        mainDiv.setAttribute('class', 'box_item col-xs-2');
        mainDiv.setAttribute('id', 'box' + pictures[item].picture_id);
        pDelete.setAttribute('id', pictures[item].picture_id);
        pDelete.src = 'http://localhost:8080/public/ressources/delete.svg';
        pLink.href = 'http://localhost:8080/Views/picture.php?id=' + pictures[item].picture_id + '&author=' + pictures[item].author_login;
        pDiv.setAttribute('class', 'pic_item');
        pImg.setAttribute('class', 'picture');
        pImg.src = 'data:image/png;base64,' + pictures[item].final_encode64;
        pDelete.setAttribute('class', 'delete_pic');

        mainDiv.appendChild(pDelete);
        pDiv.appendChild(pLink);
        pLink.appendChild(pImg);
        mainDiv.appendChild(pDiv);

        pDelete.addEventListener("click", function(e) {
          var el = document.getElementById('box' + this.getAttribute('id'))
          var data = [];
          data['action'] = 'delete';
          data['picture_id'] = this.getAttribute('id');
          request.post('http://localhost:8080/Controllers/Cont_user.php', data, function(response) {
              el.parentNode.removeChild(el);
            }, function(response) {
            }
          )
        })
        var toPic = document.getElementsByClassName('row row_pictures');
        toPic[toPic.length - 1].appendChild(mainDiv);
        i++;
        // document.getElementById('pictures').appendChild(mainDiv);
      }
    }, function(response) {
    }
  )


/*
  Gestion des event listeners
*/

/*
  Size
*/

var choice = document.getElementsByName("size");
for (var i = 0; i < choice.length; i++) {
  choice[0].checked = true;
  choice[i].addEventListener("change", function(e) {
    var myCanvas = document.getElementById('canvas');
    var myVideo = document.getElementById('video');
    var img = document.getElementById('img');
    if (e.target.checked) {
      switch (e.target.value) {
        case "small":
          myCanvas.style.width = 320;
          myCanvas.style.height = 240;
          myVideo.setAttribute('width', 320);
          height = video.videoHeight / (video.videoWidth / 320);
          img.style.width = '10%';
          window.imgWidth = img.clientWidth;
          window.imgHeight = img.clientHeight;
          window.camWidth = myCanvas.clientWidth;
          window.camHeight = myCanvas.clientHeight;
          myVideo.setAttribute('height', height);
          break;
        case "medium":
          myCanvas.style.width = 580;
          myCanvas.style.height = 380;
          myVideo.setAttribute('width', 580);
          height = video.videoHeight / (video.videoWidth / 580);
          myVideo.setAttribute('height', height);
          img.style.width = '15%';
          window.imgWidth = img.clientWidth;
          window.imgHeight = img.clientHeight;
          window.camWidth = myCanvas.clientWidth;
          window.camHeight = myCanvas.clientHeight;
        break;
        case "large":
          myCanvas.style.width = 864;
          myCanvas.style.height = 512;
          myVideo.setAttribute('width', 864);
          height = video.videoHeight / (video.videoWidth / 864);
          img.style.width = '20%';
          window.imgWidth = img.clientWidth;
          window.imgHeight = img.clientHeight;
          window.camWidth = myCanvas.clientWidth;
          window.camHeight = myCanvas.clientHeight;
          myVideo.setAttribute('height', height);
        break;
      }
    }
  })
}

(function() {

  var streaming = false,
      video        = document.querySelector('#video'),
      cover        = document.querySelector('#cover'),
      canvas       = document.querySelector('#canvas'),
      photo        = document.querySelector('#photo'),
      startbutton  = document.querySelector('#startbutton'),
      width = 320,
      height = 0;

  navigator.getMedia = (navigator.getUserMedia ||
                        navigator.webkitGetUserMedia ||
                        navigator.mozGetUserMedia ||
                        navigator.msGetUserMedia);

  navigator.getMedia({
    video: true,
    audio: false
  },
    function(stream) {
      if (navigator.mozGetUserMedia) {
        video.mozSrcObject = stream;
      } else {
        var vendorURL = window.URL || window.webkitURL;
        video.src = vendorURL.createObjectURL(stream);
      }
      video.play();
    },
    function(err) {
    }
  );

  video.addEventListener('canplay', function(ev){
    if (!streaming) {
      height = video.videoHeight / (video.videoWidth/width);
      video.setAttribute('width', width);
      video.setAttribute('height', height);
      canvas.setAttribute('width', width);
      canvas.setAttribute('height', height);
      streaming = true;
    }
  }, false);

  function takepicture() {
    var vid = document.getElementById('video');
    canvas.width = window.camWidth;
    canvas.height = window.camHeight;
    canvas.getContext('2d').drawImage(video, 0, 0, window.camWidth, window.camHeight);
    var data = [];
    data['img'] = canvas.toDataURL('image/png');
    var tmp = document.getElementById('img');
    data['name'] = tmp.getAttribute('filter_name');
    data['width'] = window.imgWidth;
    data['height'] = window.imgHeight;
    if (window.posYfilter != 0)
      data['offsetY'] = window.posYfilter.replace('px', '');
    else
      data['offsetY'] = "0";
    if (window.posXfilter != 0)
      data['offsetX'] = window.posXfilter.replace('px', '');
    else
      data['offsetX'] = "0";
    request.post(window.location.origin + "/Controllers/Cont_img.php", data,
      function(response) {
      },
      function(response) {
    });
  }

  startbutton.addEventListener('click', function(ev) {
    var allFilters = document.getElementsByName('filter');
    var flag = 0;
    var i;
    for (i = 0; i < allFilters.length; i++) {
      if (allFilters[i].checked == true) {
        flag = 1;
      }
    }
    if (flag == 1) {
      takepicture();
    }
    ev.preventDefault();
  }, false);

})();

</script>