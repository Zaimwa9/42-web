<?php

require_once "../Classes/Database.class.php";
require_once "../Classes/Misc.class.php";
require_once "../Classes/Filter.class.php";
$array_tab = ['Users', 'Comments', 'Pictures', 'Likes', 'Emails', 'Filters', 'Social', 'Reset'];

$db = Database::connectdb();

// Dropping existing tables before starting the setup
foreach ($array_tab as $table) {
  try {
    $sql = "DROP TABLE IF EXISTS " . $table . PHP_EOL;
    $db->query($sql);
    print('Successfully dropped table: ' . $table . PHP_EOL);
    print("</br>");
  } catch (PDOException $ex) {
    print('Error dropping: ' . $table . ' ---> ' . $ex);
  }
}

// Creation of table USERS
try {
  $sql = "CREATE TABLE Users (
          db_id SERIAL PRIMARY KEY,
          uid TEXT NOT NULL UNIQUE,
          login TEXT NOT NULL UNIQUE,
          password TEXT NOT NULL,
          email TEXT NOT NULL UNIQUE,
          valid_account boolean DEFAULT false,
          created_at TIMESTAMP DEFAULT now(),
          notif BOOLEAN DEFAULT true --,
          -- followers_id INTEGER ARRAY,
          -- following_ids INTEGER ARRAY
          )";
  $db->query($sql);
  print('Successfully created Users table');
  print('</br>');
} catch (PDOException $ex) {
  print('Error creating: Users ---> ' . $ex);
}

// Creation of table PICTURES
try {
  $sql = "CREATE TABLE Pictures (
          p_id SERIAL PRIMARY KEY,
          picture_id TEXT NOT NULL UNIQUE,
          raw_encode64 TEXT,
          final_encode64 TEXT,
          author_id TEXT NOT NULL,
          author_login TEXT,
          filter INTEGER,
          posted_at TIMESTAMP DEFAULT now()
          )";
  $db->query($sql);
  print('Successfully created Pictures table');
  print('</br>');
} catch (PDOException $ex) {
  print('Error creating: Pictures ---> ' . $ex);
}

// Creation of table Likes
try {
  $sql = "CREATE TABLE Likes (
          like_id SERIAL PRIMARY KEY,
          user_id INTEGER,
          picture_id INTEGER,
          comment_id INTEGER,
          like_ts TIMESTAMP DEFAULT now()
          )";
  $db->query($sql);
  print('Successfully created Likes table');
  print('</br>');
} catch (PDOException $ex) {
  print('Error creating: Likes ---> ' . $ex);
}

// Creation of table Comments
try {
  $sql = "CREATE TABLE Comments (
          comment_id SERIAL PRIMARY KEY,
          user_id INTEGER,
          user_login TEXT,
          picture_id INTEGER,
          content TEXT,
          comment_at TIMESTAMP DEFAULT now()
          )";
  $db->query($sql);
  print('Successfully created Comments table');
  print('</br>');
} catch (PDOException $ex) {
  print('Error creating: Comments ---> ' . $ex);
}

// Creation of table Emails
try {
  $sql = "CREATE TABLE Emails (
          email_id SERIAL PRIMARY KEY,
          name_desc TEXT,
          header TEXT,
          content TEXT
          )";
  $db->query($sql);
  print('Successfully created Emails table');
  print('</br>');
} catch (PDOException $ex) {
  print('Error creating: Emails ---> ' . $ex);
}

// Creation of table Filters
try {
  $sql = "CREATE TABLE Filters (
          f_id SERIAL PRIMARY KEY,
          filter_name TEXT,
          width INTEGER,
          height INTEGER,
          encode64 TEXT
          )";
  if ($db->query($sql)) {
    $root = $_SERVER["DOCUMENT_ROOT"];
    $files = scandir($root . '/img/filter/');
    foreach($files as $file) {
      if ($file != '.' && $file != '..') {
        list ($width, $height) = getimagesize($root . '/img/filter/' . $file);
        $name = $file;
        $src = base64_encode(file_get_contents($root . '/img/filter/' . $file));
        Filter::extractFilters(array('name' => $name, 'width' => $width, 'height' => $height, 'encode64' => $src));
      }
    }
  };
  print('Successfully created Filters table');
  print('</br>');
} catch (PDOException $ex) {
  print('Error creating: Filters ---> ' . $ex);
}

// Creation of table Social
try {
  $sql = "CREATE TABLE Socials (
          social_id SERIAL PRIMARY KEY,
          poster_login TEXT,
          picture_id TEXT,
          type TEXT,
          content TEXT DEFAULT NULL,
          author_login TEXT,
          posted_at TIMESTAMP DEFAULT now()
          )";
  $db->query($sql);
  print('Successfully created Socials table');
  print('</br>');
} catch (PDOException $ex) {
  print('Error creating: Socials ---> ' . $ex);
}

// Creation of table to reset password 
try {
  $sql = "CREATE TABLE Reset (
          reset_id SERIAL PRIMARY KEY,
          uid TEXT NOT NULL UNIQUE,
          login TEXT NOT NULL UNIQUE,
          email TEXT NOT NULL UNIQUE
          )";
  $db->query($sql);
  print('Successfully created Reset table');
  print('</br>');
} catch (PDOException $ex) {
  print('Error creating: Reset ---> ' . $ex);
}
?>