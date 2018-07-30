<?php
require_once 'Database.class.php';
require_once 'Misc.class.php';
require_once 'User.class.php';

class Picture {

  public $p_id, $picture_id, $raw_encode64, $final_encode64, $author_id, $author_login, $filter, $posted_at;

  public function __construct( array $kwargs) {
    if ($kwargs === null)
      return ;
    if (array_key_exists('picture_id', $kwargs) && array_key_exists('author_id', $kwargs) && array_key_exists('author_login', $kwargs)
      && array_key_exists('filter', $kwargs)) {
        $this->picture_id = $kwargs['picture_id'];
        $this->raw_encode64 = $kwargs['raw_encode64'];
        $this->final_encode64 = $kwargs['final_encode64'];
        $this->author_id = $kwargs['author_id'];
        $this->author_login = $kwargs['author_login'];
        $this->filter = $kwargs['filter'];
    }
  }

  public function addPicture() {
    $db = Database::connectdb();
    $query = $db->prepare("INSERT INTO Pictures (
                            picture_id,
                            raw_encode64,
                            final_encode64,
                            author_id,
                            author_login,
                            filter
                            ) VALUES (?, ?, ?, ?, ?, ?)");
    if ($query->execute(array($this->picture_id, $this->raw_encode64, $this->final_encode64, $this->author_id, $this->author_login, $this->filter)))
      return 1;
    else
      return null;
  }

  static function deletePicture($picture_id) {
    $db = Database::connectdb();
    $query = $db->prepare("DELETE FROM Pictures WHERE picture_id=?");
    $query->execute(array($picture_id));
  }

  static function fetchPicture($picture_id) {
    $db = Database::connectdb();
    $query = $db->prepare("SELECT * FROM Pictures WHERE picture_id=?");
    $query->setFetchMode(PDO::FETCH_INTO, new Picture(array(null)));
    if ($query->execute(array($picture_id)))
      return $query->fetch();
    else
      return null;
  }

  static function fetchPictureByAuthor($author_login) {
    $db = Database::connectdb();
    $query = $db->prepare("SELECT * FROM Pictures WHERE author_login=?");
    $query->setFetchMode(PDO::FETCH_INTO, new Picture(array(null)));
    if ($query->execute(array($author_login)))
      return $query->fetch();
    else
      return null;
  }

  static function fetchAllPictures() {
    $db = Database::connectdb();
    $query = $db->prepare("SELECT * FROM Pictures");
    if ($query->execute())
      return $query->fetchAll(PDO::FETCH_ASSOC);
    else
      return null;
  }

  static function fetchFeedPictures($user, $offset) {
    $db = Database::connectdb();
    $query = $db->prepare("SELECT p.*,
                            SUM(CASE WHEN s.type = 'like' AND s.poster_login=? THEN 1 ELSE 0 END) as is_liked,
                            COUNT(CASE WHEN s.type='comment' THEN 1 END) AS nb_coms,
                            COUNT(CASE WHEN s.type='like' THEN 1 END) AS nb_likes
                            FROM Pictures AS p LEFT JOIN Socials s ON p.picture_id=s.picture_id
                            GROUP BY 1, 2, 3, 4, 5, 6, 7, 8
                            ORDER BY p.posted_at DESC
                            LIMIT 25
                            OFFSET ?");
    if ($query->execute(array($user, $offset)))
      return $query->fetchAll(PDO::FETCH_ASSOC);
    else
      return null;
  }

  static function fetchAllPicturesByAuthor($author_login) {
    $db = Database::connectdb();
    $query = $db->prepare("SELECT * FROM Pictures WHERE author_login=? ORDER BY posted_at DESC LIMIT 20");
    if ($query->execute(array($author_login)))
      return $query->fetchAll(PDO::FETCH_ASSOC);
    else
      return null;
  }

  static function updateUserLogin($newlogin, $oldlogin) {
    $db = Database::connectdb();
    $query = $db->prepare("UPDATE Pictures SET
                            author_login=?
                            WHERE author_login=?");
    $query->execute(array($newlogin, $oldlogin));
  }
}
?>