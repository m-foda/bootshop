<?php
session_start();
if (!isset($_SESSION['loggedInAdmin']) || empty($_SESSION['loggedInAdmin'])) {
  header('Location:login.php');
}
require 'config.php';
require 'category.php';
require_once 'admin.php';

$category = new category();
$admin = new admin();
$statement = $admin->selectAllProducts();
$result = $statement->get_result();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>ADMINISTRATION | PRODUCT MANAGEMENT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0 max-scale = 1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap style -->
    <link id="callCss" rel="stylesheet" href="themes/bootshop/bootstrap.min.css" media="screen"/>
    <link rel="stylesheet" href="themes/bootshop/bootstrap.css">
    <link rel="stylesheet" href="themes/bootshop/bootstrap-theme.css">
    <link href="themes/css/base.css" rel="stylesheet" media="screen"/>
    <!-- Bootstrap style responsive -->
    <link href="themes/css/bootstrap-responsive.min.css" rel="stylesheet"/>
    <link href="themes/css/font-awesome.css" rel="stylesheet" type="text/css">
    <!-- Google-code-prettify -->
    <link href="themes/js/google-code-prettify/prettify.css" rel="stylesheet"/>
    <!-- fav and touch icons -->
    <link rel="shortcut icon" href="themes/images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="themes/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="themes/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="themes/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="themes/images/ico/apple-touch-icon-57-precomposed.png">
    <style type="text/css" id="enject"></style>
    <style media="screen">
    </style>
    <script src="./jquery-3.1.1.js">
    </script>
    <script type="text/javascript">
      $(function() {
        $('.span10:first').css('display', 'none');
        $('table').on('click','input', function(event) {
          clickedButton = event.target;
          if ($(clickedButton).attr('type') === "button" && $(clickedButton).attr('name') === "deleteProduct") {
            var $product_id = $(clickedButton).parent().parent().children(':first').text();
            console.log($product_id);
            myAjax = $.ajax({
              url: 'processproductsajax.php',
              type: 'POST',
              data: {productToDelete: $product_id}
            })
            .done(function(data) {
              if (data === "success") {
                location.reload();
              }
            })
            .fail(function() {
              console.log("error");
            })
          }
          if ($(clickedButton).attr('type') === "button" && $(clickedButton).attr('name') === "editProduct") {
            $('.categoryList').focus();
            $('.span10:first').css('display', 'inline-block');
            $('.span10:last').css('display', 'none');
            $('form:first input:eq(0)').val($(clickedButton).parent().parent().children(':nth-child(1)').text());
            $('form:first input:eq(1)').val($(clickedButton).parent().parent().children(':nth-child(2)').text());
            $('form:first input:eq(2)').val($(clickedButton).parent().parent().children(':nth-child(3)').text());
            $('form:first input:eq(4)').val($(clickedButton).parent().parent().children(':nth-child(5)').text());
            $('form:first input:eq(5)').val($(clickedButton).parent().parent().children(':nth-child(6)').text());
            $('form:first input:eq(6)').val($(clickedButton).parent().parent().children(':nth-child(7)').text());
            $('select:first').focus();
            setTimeout(function() {
              $('select:first').delay(250).val($("option:contains('"+$(clickedButton).parent().parent().children(':nth-child(8)').text()+"')").val());
            }, 500);
            $('form:first input:eq(1)').focus();
          }
        });
        $('.categoryList').on('focus', function(event) {
          myAjax4 = $.ajax({
            url: 'processproductsajax.php',
            type: 'POST',
            data: {requestCategories: 'true'}
          })
          .done(function(data) {
            data = JSON.parse(data);
            $(event.target).children().remove();
            $.each(data, function(key, value) {
              newOption = document.createElement('option');
              $(newOption).val(key);
              $(newOption).text(value);
              $(event.target).append(newOption);
            });
          })
          .fail(function() {
            console.log("error");
          })
        });
      });
    </script>

  </head>
<body>
  <div id="header">
    <div class="container">
      <div id="welcomeLine" class="row">
        <div class="span6">Welcome!<strong> <?php echo $_SESSION['loggedInAdminName']; ?></strong></div>
      </div>
      <!-- Navbar ================================================== -->
      <div id="logoArea" class="navbar">
        <a id="smallScreen" data-target="#topMenu" data-toggle="collapse" class="btn btn-navbar">
        	<span class="icon-bar"></span>
        	<span class="icon-bar"></span>
        	<span class="icon-bar"></span>
        </a>
        <div class="navbar-inner">
          <a class="brand" href="index.php"><img src="themes/images/logo.png" alt="Bootsshop"/></a>
          <ul id="topMenu" class="nav pull-right">
            <li class="">
              <a href="logout.php" style="padding-right:0"><span class="btn btn-large btn-success">Logout</span></a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div id="mainBody">
  	<div class="container">
      <div class="row">
        <ul class="breadcrumb">
          <li><a href="adminindex.php">Home</a></li>
          <li><a href="admin-manage-products.php">Product Management</a>
        </ul>
        <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Picture</th>
            <th>Quantity</th>
            <th>Brand</th>
            <th>Description</th>
            <th>Category</th>
          </tr>
        </thead>
        <tbody>
          <?php
          for ($i = 0; $i < $result->num_rows; $i++) {
            $row = $result->fetch_assoc();
            echo '<tr>';
            echo '<th scope="row">'.$row['product_id'].'</th>';
            echo '<td>'.$row['product_name'].'</td>';
            echo '<td>'.$row['price'].'</td>';
            echo '<td><img class="img-thumbnail" style="max-width: 300px;" src="'.$row['pic_path'].'" /></td>';
            echo '<td>'.$row['quantity'].'</td>';
            echo '<td>'.$row['brand'].'</td>';
            echo '<td>'.$row['description'].'</td>';
            echo '<td>';
            $category->id = $row['subcat_id'];
            $subQueryResult = $category->getById();
            if ($subQueryResult->num_rows>0) {
              $row = $subQueryResult->fetch_array();
              echo $row[0];
            }
            echo '</td>';
            echo '<td><input type="button" class="btn btn-success" name="editProduct" value="Edit">&nbsp;';
            echo '<input type="button" class="btn btn-danger" name="deleteProduct" value="Delete"></td>';
            echo '</tr>';
          }
          ?>
        </tbody>
      </table>
      </div>
      <div class="span10">
        <div class="well">
          <form action="processproductsajax.php" method="post" class="form-horizontal" enctype="multipart/form-data">
            <div class="form-group" style="display: none;">
              <div class="col-sm-5">
                <input type="text" name="productId" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2" for="productName">Name</label>
              <div class="col-sm-5">
                <input type="text" name="productName" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2" for="productPrice">Price</label>
              <div class="col-sm-5">
                <input type="number" name="productPrice" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2" for="productPicture">Picture</label>
              <div class="col-sm-5">
                <input type="file" name="productPicture" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2" for="productQuantity">Quantity</label>
              <div class="col-sm-5">
                <input type="number" name="productQuantity" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2" for="productBrand">Brand</label>
              <div class="col-sm-5">
                <input type="text" name="productBrand" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2" for="productDescription">Description</label>
              <div class="col-sm-5">
                <input type="text" name="productDescription" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2" for="productCategory">Category</label>
              <div class="col-sm-5">
                <select class="categoryList" name="productCategoryId" required></select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-5">
                <input type="submit" name="submitType" class="btn btn-primary" value="Edit Product">
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="span10">
        <div class="well">
          <form action="processproductsajax.php" method="post" class="form-horizontal" enctype="multipart/form-data">
            <div class="form-group">
              <label class="col-sm-2" for="productName">Name</label>
              <div class="col-sm-5">
                <input type="text" name="productName" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2" for="productPrice">Price</label>
              <div class="col-sm-5">
                <input type="number" name="productPrice" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2" for="productPicture">Picture</label>
              <div class="col-sm-5">
                <input type="file" name="productPicture" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2" for="productQuantity">Quantity</label>
              <div class="col-sm-5">
                <input type="number" name="productQuantity" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2" for="productBrand">Brand</label>
              <div class="col-sm-5">
                <input type="text" name="productBrand" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2" for="productDescription">Description</label>
              <div class="col-sm-5">
                <input type="text" name="productDescription" class="form-control" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2" for="productCategory">Category</label>
              <div class="col-sm-5">
                <select class="categoryList" name="productCategoryId" required></select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-5">
                <input type="submit" name="submitType" class="btn btn-primary" value="Add Product">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Footer ================================================================== -->
	<div  id="footerSection">
  	<div class="container">
      <div class="row">
  			<div class="span3">
  				<h5>ADMINSTRATION</h5>
  				<a href="adminindex.php">Adminstration Home</a>
          <a href="admin-manage-users.php">User Management</a>
  				<a href="admin-manage-products.php">Product Management</a>
  				<a href="admin-manage-categories.php">Category Management</a>
  				<a href="admin-review-orders.php">Order History</a>
  				<a href="logout.php">Logout</a>
  			 </div>
      </div>
  		<p class="pull-right">&copy; Bootshop</p>
  	</div><!-- Container End -->
	</div>
  <!-- Placed at the end of the document so the pages load faster ============================================= -->
	<script src="themes/js/jquery.js" type="text/javascript"></script>
	<script src="themes/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="themes/js/google-code-prettify/prettify.js"></script>
	<script src="themes/js/bootshop.js"></script>
  <script src="themes/js/jquery.lightbox-0.5.js"></script>
</body>
</html>
