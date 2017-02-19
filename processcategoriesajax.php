<?php
require 'config.php';
require_once 'admin.php';

$admin = new admin();
if (isset($_POST['categoryToDelete'])) {
  $category_id = (int)$_POST['categoryToDelete'];
  if ($admin->deleteCategoryById($category_id)) {
      echo "success";
  } else {
    echo "fail";
  }
}
if (isset($_POST['addCategory']) && $_POST['addCategory'] === "true") {
  $category_name = $_POST['addCategoryName'];
  $category_parentid = (int)$_POST['addCategoryParentId'];
  if ($admin->addNewCategory($category_name, $category_parentid)) {
      echo "success";
  } else {
    echo "fail";
  }
}
if (isset($_POST['updateCategory']) && $_POST['updateCategory'] === "true") {
  $category_id = (int)$_POST['updateCategoryId'];
  $category_name = $_POST['updateCategoryName'];
  $category_parentid = (int)$_POST['updateCategoryParentId'];
  if ($admin->updateCategory($category_id, $category_name, $category_parentid)) {
      echo "success";
  } else {
    echo "fail";
  }
}
if (isset($_POST['requestCategories']) && $_POST['requestCategories'] === "true") {
  $result = $admin->selectCategoryNamesAndIds();
  for ($i=0; $i < $result->num_rows; $i++) {
    $row = $result->fetch_assoc();
    $categories[$row['category_id']] = $row['category_name'];
  }
  echo json_encode($categories);
}
 ?>
