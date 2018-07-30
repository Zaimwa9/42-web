<?php
require_once 'Database.class.php';
require_once 'Misc.class.php';

// NE PAS OUBLIER TOUS LES CHECKS A METTRE QUAND ON APPELLE UNE METHODE SUR INSTANCE DE SI ELLE EXISTE ETC ...
date_default_timezone_set('Europe/Warsaw');

class User {
  public $db_id, $uid, $login, $password, $email, $valid_account, $created_at, $notif;

  public function __construct( array $kwargs) {
    if ($kwargs === null)
      return ;
    if (array_key_exists('login', $kwargs) && array_key_exists('password', $kwargs) && array_key_exists('email', $kwargs)) {
      $this->uid = Misc::gen_uid();
      $this->login = $kwargs['login'];
      $this->password = $kwargs['password']; // might need to be hashed here
      $this->email = $kwargs['email'];
      $this->notif = array_key_exists('notif', $kwargs) ? $kwargs['notif'] : 1;
      $this->created_at = date('Y-m-d H:i:s', time());
      $this->valid_account = false;
      Misc::sendMail('validation', $this);
    }
  }

  public function addUser() {
    $db = Database::connectdb();
    $query = $db->prepare("INSERT INTO Users (
                            uid,
                            login,
                            password,
                            email,
                            notif
                            ) VALUES (?, ?, ?, ?, ?)");
    $query->execute(array($this->uid, $this->login, $this->password, $this->email, $this->notif));
  }

  // Sera peut etre mieux de la mettre en static pour pouvoir checker si le user existe avant de le delete
  public function deleteUser() {
    $db = Database::connectdb();
    $query = $db->prepare("DELETE FROM Users WHERE uid=? AND login=?");
    $query->execute(array($this->uid, $this->login));
  }

  // public function update user (usable on an instance)
  public function updateUser(array $kwargs) {
    if (array_key_exists('email', $kwargs))
      $this->email = $kwargs['email'];
    if (array_key_exists('password', $kwargs))
      $this->$password = $kwargs['password'];
    $db = Database::connectdb();
    $query = $db->prepare("UPDATE Users SET
                            password=?,
                            email=?,
                            valid_account=?
                            WHERE uid=? AND login=?");
    $query->execute(array($this->password, $this->email, $this->valid_account, $this->uid, $this->login));
  }

  static function updateNotifs($login, $notifs) {
    $db = Database::connectdb();
    if (!$notifs)
      $notifs = false;
    $query = $db->prepare("UPDATE Users SET
                            notif=?
                            WHERE login=?");
    $query->execute(array($notifs, $login));
  }

  static function updateLogin($newlogin, $oldlogin) {
    $db = Database::connectdb();
    $query = $db->prepare("UPDATE Users SET
                            login=?
                            WHERE login=?");
    $query->execute(array($newlogin, $oldlogin));
  }

  static function updateEmail($newemail, $oldemail) {
    $db = Database::connectdb();
    $query = $db->prepare("UPDATE Users SET
                            email=?
                            WHERE email=?");
    $query->execute(array($newemail, $oldemail));
  }

  static function fetchUser($uid) {
    $db = Database::connectdb();
    $query = $db->prepare("SELECT * FROM Users WHERE uid=?");
    $query->setFetchMode(PDO::FETCH_INTO, new User(array(null)));
    if ($query->execute(array($uid)))
      return $query->fetch();
    else
      return null;
  }

  static function fetchUserByEmail($email) {
    $db = Database::connectdb();
    $query = $db->prepare("SELECT * FROM Users WHERE email=?");
    $query->setFetchMode(PDO::FETCH_INTO, new User(array(null)));
    if ($query->execute(array($email)))
      return $query->fetch();
    else
      return null;
  }
  
  static function fetchUserByLogin($login) {
    $db = Database::connectdb();
    $query = $db->prepare("SELECT * FROM Users WHERE login=?");
    $query->setFetchMode(PDO::FETCH_INTO, new User(array(null)));
    if ($query->execute(array($login)))
      return $query->fetch();
    else
      return null;
  }

  static function fetchAllUsers() {
    $db = Database::connectdb();
    $query = $db->prepare("SELECT * from Users");
    if ($query->execute())
      return $query->fetchAll(PDO::FETCH_ASSOC);
    else
      return null;
  }
}
?>