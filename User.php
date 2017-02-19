<?php
require 'config.php';
class User
{
	private $user_id;
	private $user_name;
	private $birthday;
	private $password;
	private $job;
	private $email;
	private $credit;
	private $address;
	private $delete_admin_id;
	private $delete_reason;



	//start constructor
	function __construct($user_id=null,$user_name,$password,$birthday,$job,$email,$credit,$address,$delete_admin_id=null, $delete_reason=null)
	{

		//set data
		$this->user_id =  isset($this->user_id)?$this->user_id:$user_id;

		$this->user_name = isset($this->user_name)?$this->user_name:$user_name;

		$this->password = isset($this->password)?$this->password:$password;

		$this->email =  isset($this->email)?$this->email:$email;

		$this->birthday =  isset($this->birthday)?$this->birthday:$birthday;

		$this->credit = isset($this->credit)?$this->credit:$credit;

		$this->job = isset($this->job)?$this->job:$job;

		$this->address = isset($this->address)?$this->address:$address;

	}//end constructor


	//set
	function __set($attr,$val){
		$this->$attr = $val;
	}

	//get
	function __get($attr){
		return $this->$attr;
	}

	//insert
	static function insert(){
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

		$query = "INSERT INTO users VALUES(NULL,?,?,?,?,?,?,?,NULL,NULL)";
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
		$result = $statment->bind_param('sssssis',$this->user_name, $this->birthday, $this->job, $this->email, $this->password, $this->credit, $this->address);
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
//end method insert
//get_by_id
	static function getById($id)
	{

		$success=true;
		//connect to database
		global $con;
		if($con->connect_errno)
		{
			echo "error connection to DB :  ".$con->connect_error."<br>";
			$success=false;
		}
		//end connection
		//query
		$query = "SELECT * FROM users WHERE user_id = ? ";

		//end query
		//prepare statment(prepare ,bind)
		$statment = $con->prepare($query);
		if(!$statment)
		{
			echo "error prepare to query in DB".$con->error."<br>";
			$success=false;
		}
		$result = $statment->bind_param('i',$id);

		//execute statement
		//check result

		if(!$result)
			{
				echo "binding faild ".$statment->error."<br>";
				$success=false;
			}//end prepare


		if (!$statment->execute())
			{
				echo "execution failed : ".$statment->error."<br>";
				$success=false;
			}
		$result = $statment->get_result();
		$user = $result->fetch_assoc();
		$statment->close();
		$con->close();
		return $user;

	}
	//end get by id
	static function getByPassword($email)
	{

		$success=true;
		//connect to database
		global $con;
		if($con->connect_errno)
		{
			echo "error connection to DB :  ".$con->connect_error."<br>";
			$success=false;
		}
		//end connection
		//query
		$query = "SELECT password FROM users WHERE email = ? ";

		//end query
		//prepare statment(prepare ,bind)
		$statment = $con->prepare($query);
		if(!$statment)
		{
			echo "error prepare to query in DB".$con->error."<br>";
			$success=false;
		}
		$result = $statment->bind_param('s',$email);

		//execute statement
		//check result

		if(!$result)
			{
				echo "binding faild ".$statment->error."<br>";
				$success=false;
			}//end prepare


		if (!$statment->execute())
			{
				echo "execution failed : ".$statment->error."<br>";
				$success=false;
			}
		$result = $statment->get_result();
		$user = $result->fetch_assoc();
		$statment->close();
		$con->close();
		return $user;

	}
	//get by email
	static function getByEmail($email)
	{

		$success=true;
		//connect to database
		global $con;
		if($con->connect_errno)
		{
			echo "error connection to DB :  ".$con->connect_error."<br>";
			$success=false;
		}
		//end connection
		//query
		$query = "SELECT * FROM users WHERE email = ? ";

		//end query
		//prepare statment(prepare ,bind)
		$statment = $con->prepare($query);
		if(!$statment)
		{
			echo "error prepare to query in DB".$con->error."<br>";
			$success=false;
		}
		$result = $statment->bind_param('s',$email);

		//execute statement
		//check result

		if(!$result)
			{
				echo "binding faild ".$statment->error."<br>";
				$success=false;
			}//end prepare


		if (!$statment->execute())
			{
				echo "execution failed : ".$statment->error."<br>";
				$success=false;
			}
		$result = $statment->get_result();
		$user = $result->fetch_assoc();
		$statment->close();
		$con->close();
		echo "getymail called";
		return $user;

	}
	//end get by email

    //get_by_user name
	static function getByName($user_name)
	{
		$success=true;
		//connect to database
		global $con;
		if($con->connect_errno)
		{
			echo "error connection to DB :  ".$con->connect_error."<br>";
			$success=false;
		}
		//end connection
		//query
		$query = "SELECT * FROM users WHERE user_name = ? ";

		//end query
		//prepare statment(prepare ,bind)
		$statment = $con->prepare($query);
		if(!$statment)
		{
			echo "error prepare to query in DB".$con->error."<br>";
			$success=false;
		}
		$result = $statment->bind_param('s',$user_name);

		//execute statement
		//check result

		if(!$result)
			{
				echo "binding faild ".$statment->error."<br>";
				$success=false;
			}//end prepare


		if (!$statment->execute())
			{
				echo "execution failed : ".$statment->error."<br>";
				$success=false;
			}
		$result = $statment->get_result();
		$user = $result->fetch_assoc();
		$statment->close();
		$con->close();
		return $user;

	}
	//end get by name

	//get_all
	static function getAll()
	{
		$success=true;
		//connect to database
		global $con;
		if($con->connect_errno)
		{
			echo "error connection to DB :  ".$con->connect_error."<br>";
			$success=false;
		}
		//end connection
		//query
		$query = "SELECT * FROM users ";

		//end query
		//prepare statment(prepare ,bind)
		$statment = $con->prepare($query);
		if(!$statment)
		{
			echo "error prepare to query in DB".$con->error."<br>";
			$success=false;
		}

		//execute statement
		//check result

		if(!$result)
			{
				echo "binding faild ".$statment->error."<br>";
				$success=false;
			}//end prepare


		if (!$statment->execute())
			{
				echo "execution failed : ".$statment->error."<br>";
				$success=false;
			}
		$result = $statment->get_result();
		/*$users [];
		$params = array('user_id','user_name','birthday','password','job','email','credit','address','delete_admin_id','delete_reason');
		while ($user=$result->fetch_object('user',$params)) {
			$users[]=$user;
		}*/
		$user = $result->fetch_assoc();
		$statment->close();
		$con->close();
		return $user;

	}
	//end get All

//update
	function update(){
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
		$query = "UPDATE users SET user_name = ? , password = ? , address = ? , birthday = ? , job = ? , email = ? , credit = ? WHERE user_id = ?";
		//end query
		//prepare statment(prepare ,bind)
		$statment = $con->prepare($query);
		if(!$statment)
		{
			echo "error prepare to query in DB".$con->error."<br>";
			$success = false;
		}
		$result = $statment->bind_param('issssssi',$this->user_id,$this->user_name,$this->password,$this->address,$this->birthday,$this->job,$this->email,$this->credit);

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
	//end update


}





?>
