<?php
require 'config.php';
session_start();

var_dump($_GET);

if(isset($_SESSION['user_name'])) {
  var_dump($_SESSION);
  $query = 'INSERT INTO shopping_cart VALUES (?, ?, 1)';
  $statement = $con->prepare($query);
  $id = (int)$_SESSION['user_id'];
  $pid = (int)$_GET['addCartId'];
  $statement->bind_param( 'ii' , $id, $pid);
  $statement->execute();
  var_dump($statement);
  header('Location:index.php');
}

?>
