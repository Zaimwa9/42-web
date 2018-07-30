<?php
require $_SERVER["DOCUMENT_ROOT"] . '/config/database.php';
  // Establishing connection with the database

class Database {
  static function connectdb () {
    global $DB_NAME, $DB_HOST, $DB_DSN, $DB_UNAME, $DB_PASSWORD, $DB_CONNECT;
    try {
      $db = new PDO($DB_CONNECT);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $ex) {
      print('Postgres: Error connecting to database -->' . $ex);
      exit;
    }
    return $db;
  }
}
?>