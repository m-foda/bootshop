<?php
class categoryclass {

	/*Attributes Section*/
	private $category_id;

	/*Setter and Getter*/
	function __set($attr,$val) {
		$this->$attr=$this->$val;
	}

	function __get($attr) {
		return $attr;
	}

	/*Static Methods*/
	static function getCatById() {

		global $con;
		global $success;
		$query="SELECT category_name, category_id FROM category WHERE parent_cat_id = 0" ;

		$statement=$con->prepare($query);
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
		return $statement;
		// $result = $statement->get_result();
		// var_dump($result);
		// return $result;
	}

static function searchSubCat() {

    global $con;
    global $success;
    $query="SELECT category_name , category_id FROM category WHERE parent_cat_id > 0" ;

    $statement=$con->prepare($query);
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

   //return $statement;
		$result = $statement->get_result();
		// var_dump($result);
		return $result;
  }
  static function searchPrice() {

    global $con;
    global $success;
    $query="SELECT category_name FROM category WHERE parent_cat_id > 0" ;

    $statement=$con->prepare($query);
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

   //return $statement;
		$result = $statement->get_result();
		// var_dump($result);
		return $result;
  }
	static function getSubCategories($mainCategory) {
		/*this function should accept a main category id and return all sub categories */
		global $con;
		global $success;
		$query = 'SELECT category_name, category_id FROM category WHERE parent_cat_id =? ';
		$statement = $con->prepare($query);
		$statement->bind_param('i', $mainCategory);
		$statement->execute();
		return $statement->get_result();
	}
}
?>
