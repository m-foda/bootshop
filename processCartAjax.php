<?php
session_start();
require 'config.php';
require 'cart.php';

if (isset($_SESSION['user_id']) && isset($_POST['productToDelete'])) {
  $uid = (int)$_SESSION['user_id'];
  $pid = (int)$_POST['productToDelete'];
  if (deleteFromCart($uid, $pid) > 0) {
    echo "success";
  } else {
    echo "fail";
  }
}
?>
