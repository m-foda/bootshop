<?php
class admin
{
    private $id;
    private $name;
    private $email;
    private $pass;

    public function __get($name) {
        return $this->$name;
    }
    public function __set($name, $value) {
        $this->$name = $value;
    }
    /*LogIn*/
    public function logIn() {
      global $con;
      $query = 'SELECT * FROM admins WHERE admin_email=? AND admin_pass=?';
      $statement = $con->prepare($query);
      $statement->bind_param('ss', $this->email, $this->pass);
      $statement->execute();
      return $statement->get_result();
    }
    /*Category Adminstration*/
    public function selectAllCategories() {
      global $con;
      $query = 'SELECT * FROM category';
      $statement = $con->prepare($query);
      $statement->execute();
      return $statement;
    }
    public function deleteCategoryById($id) {
      global $con;
      $query = 'DELETE FROM category WHERE category_id=?';
      $statement = $con->prepare($query);
      $statement->bind_param('i',$id);
      $statement->execute();
      if ($statement->affected_rows>0) {
        return TRUE;
      } else {
        return FALSE;
      }
    }
    public function addNewCategory($name, $parent_id) {
      global $con;
      $query = 'INSERT INTO category VALUES (NULL, ?, ?)';
      $statement = $con->prepare($query);
      $statement->bind_param('si', $name, $parent_id);
      $statement->execute();
      if ($statement->affected_rows>0) {
        return TRUE;
      } else {
        return FALSE;
      }
    }
    public function updateCategory($id, $name, $parent_id) {
      global $con;
      $query = 'UPDATE category SET category_name=?, parent_cat_id=? WHERE category_id=?';
      $statement = $con->prepare($query);
      $statement->bind_param('sii', $name, $parent_id, $id);
      $statement->execute();
      if ($statement->affected_rows>0) {
        return TRUE;
      } else {
        return FALSE;
      }
    }
    public function selectCategoryNamesAndIds() {
      global $con;
      $query = 'SELECT category_id, category_name FROM category WHERE parent_cat_id = 0';
      $statement = $con->prepare($query);
      $statement->execute();
      if ($statement->errno>0) {
        return FALSE;
      } else {
        return $statement->get_result();
      }
    }
    /*Product Adminstration*/
    public function selectAllProducts(){
      global $con;
      $query = 'SELECT * FROM products';
      $statement = $con->prepare($query);
      $statement->execute();
      return $statement;
    }
    public function deleteProductById($id) {
      global $con;
      $query = 'DELETE FROM products WHERE product_id=?';
      $statement = $con->prepare($query);
      $statement->bind_param('i',$id);
      $statement->execute();
      if ($statement->affected_rows>0) {
        return TRUE;
      } else {
        return FALSE;
      }
    }
    public function selectSubCategoryNamesAndIds() {
      global $con;
      $query = 'SELECT category_id, category_name FROM category WHERE parent_cat_id > 0';
      $statement = $con->prepare($query);
      $statement->execute();
      if ($statement->errno>0) {
        return FALSE;
      } else {
        return $statement->get_result();
      }
    }
    public function addNewProduct($name, $price, $picpath, $quantity, $brand, $description, $categoryid) {
      global $con;
      $query = 'INSERT INTO products VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)';
      $statement = $con->prepare($query);
      $statement->bind_param('sisissi', $name, $price, $picpath, $quantity, $brand, $description, $categoryid);
      $statement->execute();
      if ($statement->affected_rows>0) {
        return TRUE;
      } else {
        return FALSE;
      }
    }
    public function updateProduct($id, $name, $price, $picpath, $quantity, $brand, $description, $categoryid) {
      global $con;
      $query = 'UPDATE products SET product_name=?, price=?, pic_path=?, quantity=?, brand=?, description=?, subcat_id=? WHERE product_id=?';
      $statement = $con->prepare($query);
      $statement->bind_param('sisissii', $name, $price, $picpath, $quantity, $brand, $description, $categoryid, $id);
      $statement->execute();
      if ($statement->affected_rows>0) {
        return TRUE;
      } else {
        return FALSE;
      }
    }
    /*User Management*/
    public function selectAllUsers() {
      global $con;
      $query = 'SELECT * FROM users';
      $statement = $con->prepare($query);
      $statement->execute();
      return $statement;
    }
    public function deleteUserById($id) {
      global $con;
      $query = 'DELETE FROM users WHERE user_id=?';
      $statement = $con->prepare($query);
      $statement->bind_param('i',$id);
      $statement->execute();
      if ($statement->affected_rows>0) {
        return TRUE;
      } else {
        return FALSE;
      }
    }


}
