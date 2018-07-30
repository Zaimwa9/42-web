var request = {};

request.send = function (url, method, successCb, errorCb, data) {
  var req = new XMLHttpRequest();
  req.open(method, url, true);
  req.onreadystatechange = function() {
    if (req.readyState == 4) {
      if (req.status < 300) {
        successCb(req.responseText);
      } else {
        errorCb(req.status);
      }
    }
  }
  if (method == "POST")
    req.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  req.send(data);
}

request.post = function (url, data, successCb, errorCb) {
  var params = [];
  for (var key in data) {
    params.push(encodeURIComponent(key) + "=" + encodeURIComponent(data[key]));
  }
  request.send(url, "POST", successCb, errorCb, params.join('&'));
}

request.get = function(url, data, successCb, errorCb) {
  var params = [];
  for (var key in data) {
    params.push(encodeURIComponent(key) + "=" + encodeURIComponent(data[key]));
  }
  request.send(url + (params.length > 0 ? '?' + params.join('&') : '') , "GET", successCb, errorCb, null);
}