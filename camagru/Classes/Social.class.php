<?php
require_once 'Database.class.php';
require_once 'Misc.class.php';

class Social {
  static function addComment(array $kwargs) {
    $db = Database::connectdb();
    $query = $db->prepare("INSERT INTO Socials (
      poster_login,
      picture_id,
      type,
      content,
      author_login
      ) VALUES (?, ?, ?, ?, ?)");
    $query->execute(array($kwargs['poster_login'], $kwargs['picture_id'], 'comment', $kwargs['content'], $kwargs['author_login']));
  }

  static function addLike(array $kwargs) {
    $db = Database::connectdb();
    $query = $db->prepare("INSERT INTO Socials (
      poster_login,
      picture_id,
      type,
      content,
      author_login
      ) VALUES (?, ?, ?, ?, ?)");
    $query->execute(array($kwargs['poster_login'], $kwargs['picture_id'], 'like', $kwargs['content'], $kwargs['author_login']));
  }

  static function removeLike($poster_login, $picture_id) {
    $db = Database::connectdb();
    $query = $db->prepare("DELETE
                          FROM Socials 
                          WHERE type='like' AND picture_id=? AND poster_login=?");
    $query->execute(array($picture_id, $poster_login));
  }

  static function removeCom($poster_login, $picture_id, $social_id) {
    $db = Database::connectdb();
    $query = $db->prepare("DELETE
                          FROM Socials
                          WHERE type='comment' AND picture_id=? AND poster_login=? AND social_id=?");
    $query->execute(array($picture_id, $poster_login, $social_id));
  }

  static function fetchComsByPic($picture_id, $offset) {
  $db = Database::connectdb();
  $query = $db->prepare("SELECT * FROM Socials WHERE type='comment' AND picture_id=? ORDER BY posted_at DESC LIMIT 5 OFFSET ?");
  if ($query->execute(array($picture_id, $offset)))
    return $query->fetchAll(PDO::FETCH_ASSOC);
  else
    return null;
  }

  static function fetchTComs() {
    $db = Database::connectdb();
    $query = $db->prepare("SELECT * FROM Socials WHERE type='comment' ORDER BY posted_at DESC LIMIT 10");
    if ($query->execute())
      return $query->fetchAll(PDO::FETCH_ASSOC);
    else
      return null;
  }

  static function fetchLikePic($picture_id, $user_login) {
    $db = Database::connectdb();
    $query = $db->prepare("SELECT * FROM Socials
                            WHERE type='like'
                            AND picture_id=?
                            AND poster_login=?
                            ORDER BY posted_at
                            ");
    if ($query->execute(array($picture_id, $user_login)))
      return $query->fetchAll(PDO::FETCH_ASSOC);
    else
      return null;
  }

  static function updatePosterLogin($newlogin, $oldlogin) {
    $db = Database::connectdb();
    $query = $db->prepare("UPDATE Socials SET
                            poster_login=?
                            WHERE poster_login=?");
    $query->execute(array($newlogin, $oldlogin));
  }

  static function updateAuthorLogin($newlogin, $oldlogin) {
    $db = Database::connectdb();
    $query = $db->prepare("UPDATE Socials SET
                            author_login=?
                            WHERE author_login=?");
    $query->execute(array($newlogin, $oldlogin));
  }

  static function deleteSocByPic($picture_id) {
    $db = Database::connectdb();
    $query = $db->prepare("DELETE FROM Socials
                          WHERE picture_id=?");
    $query->execute(array($picture_id));
  }

  static function fetchLikesPage($picture_id, $login) {
    $db = Database::connectdb();
    $query = $db->prepare("SELECT COUNT(*) as nb_likes,
                            COUNT(CASE WHEN type='like' AND author_login=? THEN 1 END) as is_liked
                            FROM Socials
                            WHERE type='like'
                            AND picture_id=?
                            ");
    if ($query->execute(array($login, $picture_id)))
      return $query->fetchAll(PDO::FETCH_ASSOC);
    else
      return null;
  }
}
?>