<?php

function getCreditById($id, $conn) {
  $query = 'SELECT credit FROM users WHERE user_id = ?';
  $statement = $conn->prepare($query);
  $statement->bind_param( 'i' , $id);
  $statement->execute();
  $result = $statement->get_result();
  $row = $result->fetch_assoc();
  $credit = $row['credit'];
  $statement->close();
  return $credit;
}

function getCartNumById($id, $conn) {
  $query = 'SELECT * FROM shopping_cart WHERE usercart_id = ?';
  $statement = $conn->prepare($query);
  $statement->bind_param( 'i' , $id);
  $statement->execute();
  $result = $statement->get_result();
  $number = $result->num_rows;
  $statement->close();
  return $number;
}

function deleteFromCart($uid, $pid) {
  global $con;
  $query = 'DELETE FROM shopping_cart WHERE usercart_id = ? AND prodcart_id = ?';
  $statement = $con->prepare($query);
  $statement->bind_param( 'ii' , $uid, $pid);
  $statement->execute();
  return $statement->affected_rows;
}
 ?>
