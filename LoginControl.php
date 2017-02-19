<?php
session_start();
require 'config.php';
require_once 'admin.php';
require 'User.php';
var_dump($_POST);

/****************************************************login*****************************************/
	if(isset($_POST['SignUser']))
	{

		$email_user = filter_input(INPUT_POST,'email_user',FILTER_SANITIZE_EMAIL);
		$password_user = filter_input(INPUT_POST,'password_user',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		global $con;
		if($con->connect_errno)
		{
			echo "error connection to DB :  ".$con->connect_error."<br>";
			return false;
		}
		$query = "SELECT * FROM users WHERE email = ? AND password = ?";
		$statment = $con->prepare($query);
		if(!$statment)
		{
			echo "error prepare to query in DB".$con->error."<br>";
			return false;
		}
		$result = $statment->bind_param('ss',$email_user,$password_user);

		//execute statement
		//check result

		if(!$result)
			{
				echo "binding faild ".$statment->error."<br>";
				return false;
			}//end prepare


		if (!$statment->execute())
			{
				echo "execution failed : ".$statment->error."<br>";
				return false;
			}
		$result = $statment->get_result();

		$user = $result->fetch_assoc();
		if(!$user)
		{
			$statment->close();
			$con->close();

			header("Location:login.php?error=invalid");
		}
		else
		{
			$statment->close();
			$con->close();
			$_SESSION['user_name'] = $user['user_name'];
			$_SESSION['user_id'] = $user['user_id'];
			var_dump($_SESSION);
			header("Location:index.php");
		}
	}

/***************************************registeration*******************************************/
if (isset($_POST['Register']) AND $_POST['Register']=='Register') {
		$user_name = filter_input(INPUT_POST,'user_name',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$birthday = $_POST['birthday'];
		$job = filter_input(INPUT_POST,'job',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
		$password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$credit = filter_input(INPUT_POST,'credit',FILTER_SANITIZE_NUMBER_INT);
		$address = filter_input(INPUT_POST,'address',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		global $con;

		if($con->connect_errno)
		{
			echo "error connection to DB :  ".$con->connect_error."<br>";

		}
		$query = "SELECT * FROM users WHERE email = ? AND password = ?";
		$statment = $con->prepare($query);
		if(!$statment)
		{
			echo "error prepare to query in DB".$con->error."<br>";

		}
		$result = $statment->bind_param('ss',$email,$password);

		//execute statement
		//check result

		if(!$result)
			{
				echo "binding faild ".$statment->error."<br>";

			}//end prepare


		if (!$statment->execute())
			{
				echo "execution failed : ".$statment->error."<br>";

			}
		$result = $statment->get_result();

		$user = $result->fetch_assoc();
		if(!$user)
		{
			$flage="false";
			$query1 = "INSERT INTO users VALUES(NULL,?,?,?,?,?,?,?,NULL,NULL)";
			$statment1 = $con->prepare($query1);
			if(!$statment1)
			{
				echo "error prepare to query in DB".$con->error."<br>";

			}
			$result1 = $statment1->bind_param('sssssis',$user_name,$birthday,$job,$email,$password,$credit,$address);
			//execute statement
			//check result

			if(!$result1)
				{
					echo "binding faild ".$statment1->error."<br>";

				}//end prepare

			if (!$statment1->execute())
				{
					echo "execution1 failed : ".$statment1->error."<br>";
					header("Location:register.php?error");

				}

			if($statment1->affected_rows > 0) {
				$userid = User::getByEmail($email);
				$statment1->close();
				header("Location:login.php?success");


			}


		}
		else
		{
			$statment->close();
			$con->close();
			header("Location:register.php");
		}



	}

	/******************************************admin*************************************/

	if (isset($_POST['SignAdmin'])) {
		$email_admin = filter_input(INPUT_POST,'email_admin',FILTER_SANITIZE_EMAIL);
		$password_admin = filter_input(INPUT_POST,'password_admin',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$loginAdmin = new admin();
		$loginAdmin->email = $email_admin;
		$loginAdmin->pass = $password_admin;
		$loginResult = $loginAdmin->logIn();
		if ($loginResult->num_rows > 0) {
			$row = $loginResult->fetch_assoc();
			$_SESSION['loggedInAdmin'] = $row['admin_id'];
			$_SESSION['loggedInAdminName'] = $row['admin_name'];
			$_SESSION['loggedInAdminEmail'] = $row['admin_email'];
			var_dump($_SESSION);
			$con->close();
			header("Location:adminindex.php");
		} else {
			$con->close();
			header("Location:login.php?adminerror=invalid");
		}
	}

?>
