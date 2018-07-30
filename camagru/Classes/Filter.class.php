<?php
require_once 'Database.class.php';
require_once 'Misc.class.php';
require_once 'User.class.php';

class Filter {
  public $f_id, $filter_name, $width, $height, $encode64;

  static function extractFilters(array $kwargs) {
    $db = Database::connectdb();
    $query = $db->prepare("INSERT INTO Filters (
                            filter_name,
                            width,
                            height,
                            encode64
                            ) VALUES (?, ?, ?, ?)");
    $query->execute(array($kwargs['name'], $kwargs['width'], $kwargs['height'], $kwargs['encode64']));
  }

  static function fetchFilter($filter_name) {
    $db = Database::connectdb();
    $query = $db->prepare("SELECT * FROM Filters WHERE filter_name=?");
    $query->setFetchMode(PDO::FETCH_INTO, new Filter());
    if ($query->execute(array($filter_name)))
      return $query->fetch();
    else
      return null;
  }

  static function fetchAllFilters() {
    $db = Database::connectdb();
    $query = $db->prepare("SELECT * FROM Filters");
    if ($query->execute())
      return $query->fetchAll(PDO::FETCH_ASSOC);
    else
      return null;
  }
}
?>