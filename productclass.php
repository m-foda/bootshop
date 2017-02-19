<?php
class productclass{
	private $product_id;
	private $product_name;
	private $price;
	private $pic_path;
	private $quantity;
	private $brand;
	private $description;
	private $subcat_id;

	function __construct($product_id,$product_name,$price,$pic_path,$quantity,$brand,$description,$subcat_id)
	{

		// $this->product_id=$product_id;
		// $this->product_name=$product_name;
		// $this->price=$price;
		// $this->pic_path=$pic_path;
		// $this->quantity=$quantity;
		// $this->brand=$brand;
		// $this->description=$description;
		// $this->subcat_id=$subcat_id;

	}
	
	function __set($attr,$val)
	{
		$this->$attr=$this->$val;
	}

	function __get($attr)
	{
		return $attr;
	}
	// function insert()
	// {
	// 	$success=true;
	// 	$con=new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);
	// 	if($con->connect_errno)
	// 	{
	// 		echo "error connection to DB".$con->connect_error."<br>" ;
	// 		$success=false;
	// 		//exit;
	// 	}
	//global $con;
	// 	$quary="insert into products(product_id,product_name,price,pic_path,quantity,brand,description,subcat_id)values(?,?,?,?,?,?,?,?)";

	// 	$statement=$con->prepare($quary);
	// 	if (!$statement) {
	// 		echo "error preparing quary".$con->error."<br>" ;
	// 		$success=false;
	// 		//exit;
	// 	}
	// 	$result=$statement->bind_param('isisissi',$this->product_id,$this->product_name,$this->price,$this->pic_path,$this->quantity,$this->brand,$this->description,$this->subcat_id);
	// 	if(!$result)
	// 	{
	// 		echo "binding faild :". $statement->error;
	// 		$success=false;
	// 		//exit;
	// 	}

	// 	if($statement->execute()) 
	// 	{
	// 		echo "execute faild :". $statement->error;
	// 		$success=false;
	// 		//exit;
	// 	}
	// 	return $success;
	// 	//echo "product inserted successfully";
	// }

	static function getById($product_id)
	{
		// $success=true;
		// $con=new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);
		// if($con->connect_errno)
		// {
		// 	echo "error connection to DB".$con->connect_error."<br>" ;
		// 	$success=false;
		// 	//exit;
		// }
		global $con;
		$quary="select * from products where product_id=? ";

		$statement=$con->prepare($quary);
		if (!$statement) {
			echo "error preparing quary".$con->error."<br>" ;
			$success=false;
			//exit;
		}
		$result=$statement->bind_param('i',$product_id);
		if(!$result)
		{
			echo "binding faild :". $statement->error;
			$success=false;
			//exit;
		}
		//$statement->execute();
		if(!$statement->execute()) 
		{
			echo "execute faild". $statement->error;
			$success=false;
			//exit;
		}
		$result=$statement->get_result();
		/*$productclass=$result->fetch_object('productclass',array('product_id','product_name','price','pic_path','quantity','brand','description','subcat_id'));*/
		$productclass = $result->fetch_assoc();
		return $productclass;

	}

	static function getAll()
	{
		// $success=true;
		// $con=new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);
		// if($con->connect_errno)
		// {
		// 	echo "error connection to DB".$con->connect_error."<br>" ;
		// 	$success=false;
		// 	//exit;
		// }
		global $con;
		$quary="select * from products";

		$statement=$con->prepare($quary);
		if (!$statement) {
			echo "error preparing quary".$con->error."<br>" ;
			$success=false;
			//exit;
		}
		
		if(!$statement->execute()) 
		{
			echo "execute faild". $statement->error;
			$success=false;
			//exit;
		}
		return $statement->get_result();
		// $products=[];
		// $params= array('product_id','product_name','price','pic_path','quantity','brand','description','subcat_id');
		// while ($productclass=$result->fetch_object('productclass',$params))
		// {
		// 	$products[]=$productclass;
		// }
		// return $products;

	}
static function getBySubCatId($subcat_id)
	{
		// $success=true;
		// $con=new mysqli(DBHOST,DBUSER,DBPASS,DBNAME);
		// if($con->connect_errno)
		// {
		// 	echo "error connection to DB".$con->connect_error."<br>" ;
		// 	$success=false;
		// 	//exit;
		// }
		global $con;
		$quary="select * from products where subcat_id=?";

		$statement=$con->prepare($quary);
		if (!$statement) {
			echo "error preparing quary".$con->error."<br>" ;
			$success=false;
			//exit;
		}
		$result=$statement->bind_param('i',$subcat_id);
		if(!$result)
		{
			echo "binding faild :". $statement->error;
			$success=false;
			//exit;
		}
		if(!$statement->execute()) 
		{
			echo "execute faild". $statement->error;
			$success=false;
			//exit;
		}
		return $statement->get_result();
		// $result=$statement->get_result();
		// $products=[];
		// $params= array('product_id','product_name','price','pic_path','quantity','brand','description','subcat_id');
		// while ($productclass=$result->fetch_object('productclass',$params))
		// {
		// 	$products[]=$productclass;
		// }
		// return $products;

	}


 static function getByPrice($price,$subcat_id)
 	{
		
 		global $con;
 		$quary="select *from products where price < ".$price." and subcat_id=".$subcat_id." ";

	$statement=$con->prepare($quary);
 		if (!$statement) {
 			echo "error preparing quary".$con->error."<br>" ;
			$success=false;
 			//exit;
 		}
 		// $result=$statement->bind_param('ii',$subcat_id);
 		// if(!$result)
		// {
		// 	echo "binding faild :". $statement->error;
	// 	$success=false;
 		// 	//exit;
 		// }
 		if(!$statement->execute()) 
 		{
 			echo "execute faild". $statement->error;
 			$success=false;
 			//exit;
 		}
	return $statement->get_result();
		
 	}




}
// $productclass=new productclass(1,'mob',1000,'12345432sdfa',20,'samsung','mobilephone','mobiles');
// if($productclass->insert())
// {
// 	echo $productclass->product_name."inserted successfully<br>";
// }

//$productclass=new productclass(1,'mob',1000,'12345432sdfa',20,'samsung','mobilephone','23');
//$productclass->insert();
//$products=productclass::getBySubCatId(23);



 // echo "<pre>";
 // var_dump($products);
 // echo "</pre>";

?>