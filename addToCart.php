<?php
require 'config.php';
session_start();

var_dump($_GET);

if(isset($_SESSION['user_name'])) {
  $con->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
  $id = (int)$_SESSION['user_id'];
  $pid = (int)$_GET['addCartId'];
  $query = "SELECT order_quantity FROM shopping_cart WHERE usercart_id = {$id} AND prodcart_id = {$pid}";
  $result = $con->query($query);
  if ($result->num_rows == 0 ) {
    $query = "INSERT INTO shopping_cart VALUES ({$id}, {$pid}, 1)";
    $result = $con->query($query);
  } else {
    $quantity = $result->fetch_assoc()['order_quantity'];
    $quantity += 1;
    $query = "UPDATE shopping_cart SET order_quantity = {$quantity} WHERE usercart_id = {$id} AND prodcart_id = {$pid}";
    $result = $con->query($query);
  }
  $con->commit();
  header("Location:index.php");
}

?>
