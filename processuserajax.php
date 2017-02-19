<?php
require 'config.php';
require_once 'admin.php';

$admin = new admin();
if (isset($_POST['userToDelete'])) {
  $user_id = (int)$_POST['userToDelete'];
  if ($admin->deleteUserById($user_id)) {
      echo "success";
  } else {
    echo "fail";
  }
}
?>
