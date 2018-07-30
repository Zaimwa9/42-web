<?php
  session_start();
  include $_SERVER["DOCUMENT_ROOT"] . "/Views/header.php";
?>
<head>
  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
  <link rel="stylesheet" href="http://localhost:8080/public/css/page.css">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

</head>
<body>
<div class="container">
    <div class="row">
  <div id="page" class="row col-xs-12">
<?php
  print (
    '
    <div class="comment_section col-xs-5 pull-right" id="comment_section">
    <h4 id="title">Comments</h4>
    '
  );
  if ($_SESSION['user']) {
    print (
            '
              <div class="comment_block">
                <div class="com_box" id="sub_com">
                  <textarea name="" id="comment_input" cols="30" rows="3" placeholder="Add comment..."></textarea>
                </div>
              </div>
              <input class="submit" type="submit" onclick="postCom()"></input>
            '
    );
  }
  print (
          '
          <button class="btn btn-primary" id="more">See more</button>
          </div>
          '
  );
?>
      </div> <!-- end of row -->
    </div> <!-- end of container -->
  </div>
</body>

<script src="../scripts/req_handler.js"></script>

<script>
  var params = [];
  params['id'] = findGetParameter('id');
  params['author'] = findGetParameter('author');
  params['offset'] = 0;
  init();

  document.getElementById('more').addEventListener("click", fetchCom);

  function fetchCom() {
    request.get(window.location.origin + "/Controllers/Cont_social.php", params, function(response) {
      window.params['offset'] += 5;
      var resp = JSON.parse(response);
      if (!resp || resp.length < 5) {
        var more = document.getElementById('more');
        more.parentNode.removeChild(more);
      }
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

        /*
          Beginning of delete function on com
        */

        if (document.getElementById('uname')) {
          if (document.getElementById('uname').innerHTML == com.poster_login) {
            var cDelete = document.createElement('img');
            cDelete.setAttribute('class', 'delete_com');
            cDelete.setAttribute('id', com.social_id);
            cDelete.src = 'http://localhost:8080/public/ressources/delete.svg';

            cDelete.addEventListener("click", function(e) {
              var el = document.getElementById('com' + this.getAttribute('id'))
              var data = [];
              data['social_id'] = this.getAttribute('id');
              data['poster_login'] = com.poster_login;
              data['picture_id'] = com.picture_id;
              data['type'] = 'comment';
              data['action'] = 'remove';
              request.post('http://localhost:8080/Controllers/Cont_Social.php', data, function(response) {
                  el.parentNode.removeChild(el);
                }, function(response) {
                  console.log('error');
                }
              )
            })
          }
        }

        /*
          End of delete function on com
        */

        cContent.setAttribute('class', 'com_content');
        cInfo.innerHTML = com.poster_login + ' - ' + com.posted_at;
        cContent.innerHTML = com.content;

        cDiv.appendChild(cContent);
        cDiv.appendChild(idDiv);
        idDiv.appendChild(cInfo);
        cblockDiv.appendChild(cDiv);
        (document.getElementById('uname') && document.getElementById('uname').innerHTML == com.poster_login ? idDiv.appendChild(cDelete) : '');
        document.getElementById('comment_section').appendChild(cblockDiv);
      })
    }, function(reponse) {
      console.log('failed');
    });
  }

  function init() {
    if (document.getElementById('uname')) {
      var username = document.getElementById('uname').innerHTML;
    };
    request.get(window.location.origin + "/Controllers/Cont_feed.php", params, function(response) {
      fetchCom();
      var picture = JSON.parse(response);
      var pDiv = document.createElement('div');
      var pImg = document.createElement('img');
      var pText = document.createElement('p');
      var pLink = document.createElement('a');
      var buttonDiv = document.createElement('div');
      var pButton = document.createElement('button');


      pDiv.setAttribute('class', 'row pic_box col-xs-7');
      pDiv.setAttribute('id', 'pic_box');
      pImg.setAttribute('class', 'picture col-xs-12');
      pText.setAttribute('class', 'desc');
      pButton.setAttribute('class', 'btn btn-primary dl_button');
      pText.setAttribute('id', 'desc');
      pLink.setAttribute('id' , 'download');
      pLink.href = 'data:image/png;base64,' + picture.final_encode64;
      pLink.download = picture.picture_id + '.png';
      buttonDiv.setAttribute('id', 'likesave');
      buttonDiv.setAttribute('class', 'row');
      pButton.textContent = 'Save';
      pLink.appendChild(pButton);
      buttonDiv.appendChild(pLink);
      pText.innerHTML = 'Posted by ' + picture.author_login + ' - ' + picture.posted_at;
      pImg.src = 'data:image/png;base64,' + picture.final_encode64;
      pDiv.appendChild(pImg);
      pDiv.appendChild(pText);
      pDiv.appendChild(buttonDiv);

      if (username && username == picture.author_login) {
        var pDelete = document.createElement('img');
        pDelete.setAttribute('id', picture.picture_id);
        pDelete.src = 'http://localhost:8080/public/ressources/delete.svg';
        pDelete.setAttribute('class', 'delete_pic');

        pDelete.addEventListener("click", function(e) {
          var data = [];
          data['action'] = 'delete';
          data['picture_id'] = this.getAttribute('id');
          request.post('http://localhost:8080/Controllers/Cont_user.php', data, function(response) {
              window.location = 'http://localhost:8080/index.php';
            }, function(response) {
              console.log('error');
            }
          )
        })
        pDiv.appendChild(pDelete);
      }

      document.getElementById('page').insertBefore(pDiv, document.getElementById('comment_section'));
      
      /*
          Once the picture has been retrieved we request db to insert like
      */

      request.get(window.location.origin + '/Controllers/Cont_social.php', req, function(response) {
        var resp = JSON.parse(response);

        var likeDiv = document.createElement('div');
        var likeImg = document.createElement('img');
        var likeCnt = document.createElement('p');
        likeImg.src = 'http://localhost:8080/public/ressources/' + (resp[0].is_liked > 0 ? 'Filledheart.svg' : 'Emptyheart.svg');
        likeCnt.innerHTML = resp[0].nb_likes;
        
        likeDiv.setAttribute('class', 'like_wrap col-xs-12');
        likeDiv.setAttribute('id', 'like_wrap');
        likeImg.setAttribute('id', 'likeimg');
        likeImg.setAttribute('action', (resp[0].is_liked > 0 ? 'remove' : 'add'));
        likeCnt.setAttribute('id', 'likecnt');
        /*
        event listener
        */
        if (document.getElementById('uname')) {
          likeImg.addEventListener("click", function(e) {
            var data = [];
            data['type'] = 'like';
            data['picture_id'] = window.params['id']
            data['action'] = this.getAttribute('action');
            data['author_login'] = window.params['author'];
            var likecnt = document.getElementById('likecnt');
            if (data['action'] == 'add') {
              request.post(window.location.origin + "/Controllers/Cont_Social.php", data, function(response) {
                var currImg = document.getElementById('likeimg');
                currImg.src = 'http://localhost:8080/public/ressources/Filledheart.svg';
                currImg.setAttribute('action', 'remove');
                likecnt.innerHTML = parseInt(likecnt.innerHTML) + 1;
                }, function(response) {
                console.log('failed');
              })
            } else if (data['action'] == 'remove') {
              request.post(window.location.origin + "/Controllers/Cont_Social.php", data, function(response) {
                var currImg = document.getElementById('likeimg');

                currImg.src = 'http://localhost:8080/public/ressources/Emptyheart.svg';
                currImg.setAttribute('action', 'add');
                likecnt.innerHTML = (parseInt(likecnt.innerHTML) - 1 < 0 ? 0 : parseInt(likecnt.innerHTML) - 1);
                }, function(response) {
                console.log('failed');
              })
            }
          });
        }
        likeDiv.appendChild(likeImg);
        likeDiv.appendChild(likeCnt);

        document.getElementById('likesave').insertBefore(likeDiv, document.getElementById('download'));
        /*
          End of like request and insertion
        */
    }, function(response) {
      console.log('error');
    }
  )
    }, function(response) {
      console.log('error');
    })
  }

  function postCom() {
    var data = [];
    data['content'] = document.getElementById('comment_input').value;
    data['content'] = data['content'].replace('<script>', 'hello');
    data['content'] = data['content'].replace('<' + '?', 'yo');
    data['author_login'] = params['author'];
    data['picture_id'] = params['id'];
    data['type'] = 'comment';
    date = new Date();
    var datarray = [];
    datarray = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    datevalues = [
      '0' + date.getDate(),
      datarray[date.getUTCMonth()],
      date.getFullYear(),
    ];
    data['posted_at'] = datevalues.join(' ');
    
    request.post(window.location.origin + '/Controllers/Cont_social.php', data, function(response) {
      document.getElementById('comment_input').value = '';
      var cDiv = document.createElement('div');
      var cblockDiv = document.createElement('div');
      var cInfo = document.createElement('div');
      var cContent = document.createElement('p');
      var idDiv = document.createElement('div');

      cblockDiv.setAttribute('class', 'comment_block');
      idDiv.setAttribute('class', 'imgdesc');
      cDiv.setAttribute('class', 'com_box');
      cDiv.setAttribute('id', 'com' + data['posted_at'])
      cInfo.setAttribute('class', 'com_desc');

      var cDelete = document.createElement('img');
      cDelete.setAttribute('class', 'delete_com');
      cDelete.setAttribute('id', data['posted_at']);
      cDelete.src = 'http://localhost:8080/public/ressources/delete.svg';

      cDelete.addEventListener("click", function(e) {
        var el = document.getElementById('com' + this.getAttribute('id'))
        var data = [];
        data['social_id'] = this.getAttribute('id');
        data['poster_login'] = document.getElementById('uname').innerHTML;
        data['picture_id'] = params['id'];
        data['type'] = 'comment';
        data['action'] = 'remove';
        data['latest'] = true;
        request.post('http://localhost:8080/Controllers/Cont_Social.php', data, function(response) {
            el.parentNode.removeChild(el);
          }, function(response) {
        //    console.log('error');
          }
        )
      })
      cContent.setAttribute('class', 'com_content');
      cInfo.innerHTML = document.getElementById('uname').innerHTML + ' - ' + data.posted_at
      cContent.innerHTML = data.content;

      cDiv.appendChild(cContent);
      cDiv.appendChild(idDiv);
      idDiv.appendChild(cInfo);
      idDiv.appendChild(cDelete);
      cblockDiv.appendChild(cDiv);
    
      document.getElementById('comment_section').insertBefore(cblockDiv, document.getElementsByClassName('comment_block')[1]);
    }, function(response) {
      //console.log('failed');
    })
  }

  var req = [];
  req['retrieve'] = 1;
  req['id'] = params['id'];
  req['user'] = params['author'];

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