<?php

//Class that will have several useful cross-class methods (ex: mail && uuid)
class Misc {
  static function gen_uid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

        // 16 bits for "time_mid"
        mt_rand( 0, 0xffff ),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand( 0, 0x0fff ) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand( 0, 0x3fff ) | 0x8000,

        // 48 bits for "node"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
  }

  static function gen_pid($login) {
    return $login . '-' . time();
  }
// WILL NEED TO GET POSITION AND SIZE FROM FRONT IF DONE PROPERLY
  function mergeImg($source, $mask, $info, $attFilter) {
    $source2 = imagecreatefromstring(base64_decode($source));
    $mask2 = imagecreatefromstring(base64_decode($mask));

    list($targetImage, $newWidth, $newHeight) = Misc::resizeImg($source, $mask, $attFilter['width']);
    // imagecopyresized($source2, $targetImage, $info[0] / 2 - $newWidth / 2, $info[1] / 2 - $newHeight / 2, 0, 0, $newWidth, $newHeight, $newWidth, $newHeight);
    imagecopyresized($source2, $targetImage, $attFilter['offsetX'], $attFilter['offsetY'], 0, 0, $newWidth, $newHeight, $newWidth, $newHeight);
    ob_start();
    imagepng($source2);
    $final_pic = ob_get_contents();
    ob_end_clean();
    return $final_pic;
}

  function resizeImg($source, $mask, $targetWidth) {
    list($uploadWidth, $uploadHeight) = getimagesizefromstring(base64_decode($source));
    $mskImage = imagecreatefromstring(base64_decode($mask));
    list($width, $height) = getimagesizefromstring(base64_decode($mask));
    $newWidth = $targetWidth; // Sera egal directement a targetWidth plus tard
    $newHeight = ($height / $width) * $newWidth;
    $targetImage = imagecreatetruecolor($newWidth, $newHeight);
    imagealphablending($targetImage, false);
    imagesavealpha($targetImage, true);
    imagecopyresampled($targetImage, $mskImage,
                        0, 0,
                        0, 0,
                        $newWidth, $newHeight,
                        $width, $height);
    return [ $targetImage, $newWidth, $newHeight ];
  }

  static function addReset(array $kwargs) {
    $db = Database::connectdb();
    $query = $db->prepare("INSERT INTO Reset (
                            uid,
                            login,
                            email
                            ) VALUES (?, ?, ?)");
    $query->execute(array($kwargs['uid'], $kwargs['login'], $kwargs['email']));
  }

  static function removeReset($email) {
    $db = Database::connectdb();
    $query = $db->prepare("DELETE FROM Reset
                          WHERE email=?");
    $query->execute(array($email));
  }

  static function checkReset($email) {
    $db = Database::connectdb();
    $query = $db->prepare("SELECT * FROM Reset
                          WHERE email=?");
    $query->setFetchMode(PDO::FETCH_ASSOC);
    if ($query->execute(array($email)))
      return $query->fetch();
    else
      return null;
  }

  static function sendMail($type, $user) {
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    switch ($type) {
      case 'validation':
        mail($user->email, 'Welcome to Camagru ' . $user->login, Misc::generateMail($type, $user), $headers);
        break ;
      case 'reset':
        mail($user->email, 'Camagru - Password reset', Misc::generateMail($type, $user), $headers);
        break ;
      case 'newCom':
        mail($user['email'], $user['poster_login'] . ' posted a comment !', Misc::generateMail($type, $user), $headers);
        break;
    }
  }

  static function generateMail($type, $user) {
    switch ($type) {
      case 'validation':
        $link = "http://localhost:8080/Controllers/validation.php?0=" . $user->uid . "&1=" . $user->login;
        $content = "Hello " . $user->login . " and welcome !\n\nWe are glad to have you on board !
        \nBefore you can fully enjoy all the features we'll need you to please 
        click on this link to validate your account: \n\n\t\t" . $link . "\n\n Thank you and see you soon on Camagru !";
        return $content;
        break ;
      case 'reset':
        $link = "http://localhost:8080/Views/resetpage.php?0=" . $user->uid . "&1=" . $user->login;
        $content = "Hello " . $user->login . "\n\nTo reset your password please follow this link:\n\n" . $link . "\n\nHave a good day !\n\nThe Camagru team";
        return $content;
        break ;
      case 'newCom':
        $link = "http://localhost:8080/Views/picture.php?id=" . $user['picture_id'] . "&author=" . $user['login'];
        $content = "<body>Hi " . $user['login'] . "!<br><br> Your shot is on fire !<br><br>" . $user['poster_login'] . " added this comment on <a href=" . $link . ">" 
                    . $user['picture_id'] . "</a>:<br><br><q>" . $user['content'] . "</q><br><br> See you soon !</body>";
        return $content;
        break;
    }
  }
}
?>