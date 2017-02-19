<?php
		require 'config.php';
		$email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
		global $con;
		if($con->connect_errno)
		{
			echo "error connection to DB :  ".$con->connect_error."<br>";
			return false;
		}
		$query = "SELECT * FROM users WHERE email = ?";
		$statment = $con->prepare($query);
		if(!$statment)
		{
			echo "error prepare to query in DB".$con->error."<br>";
			return false;
		}
		$result = $statment->bind_param('s',$email);

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

			$json = json_encode($email);
			echo "success";
		}
		else
		{
			$json = json_encode($email);
			echo "failed";

		}




 ?>
