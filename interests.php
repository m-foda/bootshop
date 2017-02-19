<?php
require '../Model/config.php';
class interests{
	  private $id;
	  private $category_name;
		function __set($attr,$val){
			$this->$attr = $val;
		}

		//get
		function __get($attr){
			return $this->$attr;
		}
		function __construct($id,$category_name)
		{
			$this->id=isset($this->id)?$this->id:$id;
			$this->category_name=isset($this->category_name)?$this->category_name:$category_name;
		}
		

		 static function interestsById($id,$category_name)
		{
			$success = true;
		//connect to database 
		global $con;
		if($con->connect_errno)
		{
			echo "error connection to DB :  ".$con->connect_error."<br>";
			$success = false;
		}
		//end connection
		//query

		$query = "INSERT INTO interests VALUES(?,?)";
		//end query
		//prepare statment(prepare ,bind)
		
		$statment = $con->prepare($query);
		var_dump($statment);
		if(!$statment)
		{
			echo "error prepare to query in DB".$con->error."<br>";
			$success = false;
		}
		var_dump($statment);
		$result = $statment->bind_param('ii',$id, $category);
		//execute statement
		//check result

		if(!$result)
			{
				echo "binding faild ".$statment->error."<br>";
				$success = false;
			}//end prepare

		
		if (!$statment->execute())
			{
				echo "execution failed : ".$statment->error."<br>";
				$success = false;
			}
		
		return $success;
			
		}

}


?>