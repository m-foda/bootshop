<?php
class category {
  private $id;
  public function __get($name) {
    return $this->$name;
  }
  public function __set($name, $value) {
    $this->$name = $value;
  }
  public function getById() {
    global $con;
    $query = 'SELECT category_name FROM category WHERE category_id=?';
    $statement = $con->prepare($query);
    $statement->bind_param('i',$this->id);
    $statement->execute();
    return $statement->get_result();
  }
  /*public function getALL()
  {
    global $con;
    $query = 'SELECT category_name , category_id FROM category ';
    $statement = $con->prepare($query);
    $user = $statement->fetch_assoc();
    return $user;
  }*/
}
 ?>
