<?php
  session_start();
?>
<head>
  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
  <link rel="stylesheet" href="../public/css/feed.css">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

</head>

<body>
<div class="row">
  <div class="feed col-md-8 col-xs-12" id="feed">
    <div class="loader" id="loader">
      <div class="circle">
        <div class="inner-circle">
        </div>
      </div>
    </div>
  </div>

  <div class="trending col-md-3 hidden-xs hidden-sm" id="trending">
    <h1>Latest comments</h1>
  </div>
</div>
</body>

<script src="../scripts/req_handler.js"></script>

<script>
  /*
    THIS IS THE LOGIC WHEN DOCUMENT IS READY TO FETCH ALL THE PICTURES
  */
  var data = [];
  var lastScrollTop = 0;
  data['offset'] = 0;
  var ajaxPrevent = 0;

  fetchPic();
  fetchTComs();

  function fetchPic() {
    request.get(window.location.origin + "/Controllers/Cont_feed.php", data, function(response) {
    var pictures = JSON.parse(response);
    var load = (data['offset'] == 0 ? 'loader' : 'loader2');
    window.data['offset'] += 25;
    var el = document.getElementById(load);
    el.parentNode.removeChild(el);
    if (!pictures || pictures.length < 25)
      window.removeEventListener("scroll", requestor);
    for (var item in pictures) {
      var mainDiv = document.createElement('div');
      var pDiv = document.createElement('div');
      var pLink = document.createElement('a');
      var pImg = document.createElement('img');
      // var pText = document.createElement('p');
      var lcDiv = document.createElement('div');
      var likeDiv = document.createElement('div');
      var comDiv = document.createElement('div');
      var likeImg = document.createElement('img');
      var comImg = document.createElement('img');
      var likeText = document.createElement('p');
      var comText = document.createElement('p');

      mainDiv.setAttribute('class', 'box_item');
      mainDiv.setAttribute('id', 'box');
      pLink.href = 'http://localhost:8080/Views/picture.php?id=' + pictures[item].picture_id + '&author=' + pictures[item].author_login;
      // pText.innerHTML = 'Posted by ' + pictures[item].author_login + ' - ' + pictures[item].posted_at;
      pDiv.setAttribute('class', 'pic_item');
      pImg.setAttribute('class', 'picture');
      // pText.setAttribute('class', 'desc');
      pImg.src = 'data:image/png;base64,' + pictures[item].final_encode64;

      /*
      Like and Comments
      */
      lcDiv.setAttribute('class', 'likecom');
      likeDiv.setAttribute('class', 'like_box');
      comDiv.setAttribute('class', 'com_box_pic');
      likeText.setAttribute('id', pictures[item].picture_id + 'text');

      likeImg.src = 'http://localhost:8080/public/ressources/' + (pictures[item].is_liked > 0 ? 'Filledheart.svg' : 'Emptyheart.svg');
      comImg.src = 'http://localhost:8080/public/ressources/comments.svg';
      
      likeText.innerHTML = ' ' + pictures[item].nb_likes;
      likeImg.setAttribute('author', pictures[item].author_login);
      likeImg.setAttribute('id', pictures[item].picture_id + 'img');
      likeImg.setAttribute('picture_id', pictures[item].picture_id);
      likeImg.setAttribute('action', (pictures[item].is_liked > 0 ? 'remove' : 'add'));
      likeImg.style.cursor = (document.getElementById('uname') ? "hand" : "");
      comText.innerHTML = ' ' + pictures[item].nb_coms;
      
      // event handler to like or unlike
      if (document.getElementById('uname')) {
        likeImg.addEventListener("click", function(e) {
          var data = [];
          data['type'] = 'like';
          data['picture_id'] = this.getAttribute('picture_id');
          data['action'] = this.getAttribute('action');
          data['author_login'] = this.getAttribute('author');

          if (data['action'] == 'add') {
            request.post(window.location.origin + "/Controllers/Cont_Social.php", data, function(response) {
              var currImg = document.getElementById(data['picture_id'] + 'img');
              var el = document.getElementById(data['picture_id'] + 'text');
              currImg.src = 'http://localhost:8080/public/ressources/Filledheart.svg';
              currImg.setAttribute('action', 'remove');
              el.innerHTML = parseInt(el.innerHTML) + 1;
              }, function(response) {
            })
          } else if (data['action'] == 'remove') {
            request.post(window.location.origin + "/Controllers/Cont_Social.php", data, function(response) {
              var currImg = document.getElementById(data['picture_id'] + 'img');
              var el = document.getElementById(data['picture_id'] + 'text');

              currImg.src = 'http://localhost:8080/public/ressources/Emptyheart.svg';
              currImg.setAttribute('action', 'add');
              el.innerHTML = (parseInt(el.innerHTML) - 1 < 0 ? 0 : parseInt(el.innerHTML) - 1);
              }, function(response) {
            })
          }
        });
      }
        pDiv.appendChild(pLink);
        pLink.appendChild(pImg);
        // pDiv.appendChild(pText);
        likeDiv.appendChild(likeImg);
        likeDiv.appendChild(likeText);
        comDiv.appendChild(comImg);
        comDiv.appendChild(comText);
        lcDiv.appendChild(likeDiv);
        lcDiv.appendChild(comDiv);
        mainDiv.appendChild(pDiv);
        mainDiv.appendChild(lcDiv);

        document.getElementById('feed').appendChild(mainDiv);
      }
      window.ajaxPrevent = 0;
    }, function(response) {
      console.log('Server error');
    })
  }

  function requestor() {
    var st = document.body.scrollTop;
    if (window.ajaxPrevent == 0 && document.body.scrollHeight >= document.body.scrollTop + window.innerHeight - 100) {
      if (st > window.lastScrollTop) {
        window.ajaxPrevent = 1;
        var loadDiv = document.createElement('div');
        var innDiv = document.createElement('div');
        var outDiv = document.createElement('div');

        innDiv.setAttribute('class', 'inner-circle');
        outDiv.setAttribute('class', 'circle');
        outDiv.appendChild(innDiv);
        loadDiv.setAttribute('class', 'loader');
        loadDiv.setAttribute('id', 'loader2');
        loadDiv.appendChild(outDiv);
        // document.getElementById('feed').appendChild(loadDiv);
        document.body.appendChild(loadDiv)
        setTimeout(fetchPic, 1000);
      }
    }
  }

  function fetchTComs() {
    var data = [];
    data['trending'] = 1;
    request.get(window.location.origin + "/Controllers/Cont_Social.php", data, function(response) {
        var resp = JSON.parse(response);
        resp.forEach(function(com) {
          var cDiv = document.createElement('div');
          var cblockDiv = document.createElement('div');
          var cInfo = document.createElement('div');
          var cContent = document.createElement('p');
          var idDiv = document.createElement('div');
  
          idDiv.setAttribute('class', 'imgdesc');
          cblockDiv.setAttribute('class', 'comment_block');
          cDiv.setAttribute('class', 'com_box');
          cDiv.setAttribute('id', 'com' + com.social_id)
          cInfo.setAttribute('class', 'com_desc');

          cContent.setAttribute('class', 'com_content');
          cInfo.innerHTML = com.poster_login + ' commented ' + com.picture_id + ' - ' + com.posted_at;
          cContent.innerHTML = com.content;
  
          cDiv.appendChild(cContent);
          cDiv.appendChild(idDiv);
          idDiv.appendChild(cInfo);
          cblockDiv.appendChild(cDiv);

          document.getElementById('trending').appendChild(cblockDiv);
        })
      }, function(response) {
        console.log('err');
      }
    )
  }

  window.addEventListener("scroll", requestor);
</script>