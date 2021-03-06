<?php
require 'config.php';
session_start();
$con->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
$query = "INSERT INTO log VALUES(NULL,{$_SESSION['user_id']},NULL)";
$con->query($query);
$inserted_order_id = $con->insert_id;
$totalPrice = 0;
foreach ($_SESSION['cart'] as $product_id => $quantity) {
  $query = "SELECT price FROM products WHERE product_id = {$product_id}";
  $result = $con->query($query);
  $pricePerUnit = $result->fetch_assoc()['price'];
  $totalPrice += $pricePerUnit * $quantity;
}
$query = "SELECT credit FROM users WHERE user_id = {$_SESSION['user_id']}";
$result = $con->query($query);
$credit = $result->fetch_assoc()['credit'];
$remainingCredit = $credit - $totalPrice;
if ($remainingCredit > 0) {
  foreach ($_SESSION['cart'] as $product_id => $quantity) {
    $query = "INSERT INTO orders VALUES({$inserted_order_id},{$product_id},{$quantity})";
    $con->query($query);
    $query = "SELECT quantity FROM products WHERE product_id= {$product_id}";
    $quantity = $con->query($query);
    $quantity = $quantity->fetch_assoc()['quantity'] - 1;
    $query = "UPDATE products SET quantity = {$quantity} WHERE product_id = {$product_id}";
    $con->query($query);
    $query = "UPDATE users SET credit = {$remainingCredit} WHERE user_id = {$_SESSION['user_id']}";
    $con->query($query);
    $query = "DELETE FROM shopping_cart WHERE prodcart_id = {$product_id} AND usercart_id = {$_SESSION['user_id']}";
    $con->query($query);
  }
}
$con->commit();
if ($con->errno == 0) {
  echo "Success";
  header('location:index.php');
} else {
  echo "Fail";
  header('location:product_summary?error=checkoutfailed');
}
?>
