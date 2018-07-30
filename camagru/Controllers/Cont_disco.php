<?php
session_start();
foreach($_SESSION as $key => $elem) {
  unset($_SESSION[$key]);
}
?>