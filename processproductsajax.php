<?php
require 'config.php';
require_once 'admin.php';

$admin = new admin();
if (isset($_POST['productToDelete'])) {
  $product_id = (int)$_POST['productToDelete'];
  if ($admin->deleteProductById($product_id)) {
      echo "success";
  } else {
    echo "fail";
  }
}
if (isset($_POST['submitType']) && $_POST['submitType'] === "Add Product") {
  var_dump($_POST);
  $product_name = $_POST['productName'];
  $product_price = (int)$_POST['productPrice'];
  $product_quantity = (int)$_POST['productQuantity'];
  $product_brand = $_POST['productBrand'];
  $product_description = $_POST['productDescription'];
  $product_categoryid = (int)$_POST['productCategoryId'];
  /*Image Handling*/
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["productPicture"]["name"]);
  $uploadOk = 1;
  $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
  // Check if image file is a actual image or fake image
  $check = getimagesize($_FILES["productPicture"]["tmp_name"]);
  if($check !== false) {
      echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
  } else {
      echo "File is not an image.";
      $uploadOk = 0;
  }
  // Check file size
  if ($_FILES["productPicture"]["size"] > 1000000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
  }
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
  }
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
      if (move_uploaded_file($_FILES["productPicture"]["tmp_name"], $target_file)) {
          echo "The file ". basename( $_FILES["productPicture"]["name"]). " has been uploaded.";
          $product_picpath = './uploads/'.basename( $_FILES["productPicture"]["name"]);
          echo $product_picpath;
          $admin->addNewProduct($product_name, $product_price, $product_picpath, $product_quantity, $product_brand, $product_description, $product_categoryid);
          header('Location:admin-manage-products.php');
      } else {
          echo "Sorry, there was an error uploading your file.";
      }
  }
}
if (isset($_POST['submitType']) && $_POST['submitType'] === "Edit Product") {
  var_dump($_POST);
  $product_id = (int)$_POST['productId'];
  $product_name = $_POST['productName'];
  $product_price = (int)$_POST['productPrice'];
  $product_quantity = (int)$_POST['productQuantity'];
  $product_brand = $_POST['productBrand'];
  $product_description = $_POST['productDescription'];
  $product_categoryid = (int)$_POST['productCategoryId'];
  /*Image Handling*/
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["productPicture"]["name"]);
  $uploadOk = 1;
  $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
  // Check if image file is a actual image or fake image
  $check = getimagesize($_FILES["productPicture"]["tmp_name"]);
  if($check !== false) {
      echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
  } else {
      echo "File is not an image.";
      $uploadOk = 0;
  }
  // Check file size
  if ($_FILES["productPicture"]["size"] > 1000000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
  }
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
  }
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
      if (move_uploaded_file($_FILES["productPicture"]["tmp_name"], $target_file)) {
          echo "The file ". basename( $_FILES["productPicture"]["name"]). " has been uploaded.";
          $product_picpath = './uploads/'.basename( $_FILES["productPicture"]["name"]);
          echo $product_picpath;
          $admin->updateProduct($product_id, $product_name, $product_price, $product_picpath, $product_quantity, $product_brand, $product_description, $product_categoryid);
          header('Location:admin-manage-products.php');
      } else {
          echo "Sorry, there was an error uploading your file.";
      }
  }
}
if (isset($_POST['requestCategories']) && $_POST['requestCategories'] === "true") {
  $result = $admin->selectSubCategoryNamesAndIds();
  for ($i=0; $i < $result->num_rows; $i++) {
    $row = $result->fetch_assoc();
    $categories[$row['category_id']] = $row['category_name'];
  }
  echo json_encode($categories);
}
 ?>
