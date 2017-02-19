<?php
session_start();
if(isset($_SESSION['user_name'])) {
	session_destroy();
	unset($_SESSION['user_name']);
	header("Location:index.php");
} elseif (isset($_SESSION['loggedInAdmin'])) {
	session_destroy();
	header("Location:login.php");
} else {
	header("Location:index.php");
}
?>
