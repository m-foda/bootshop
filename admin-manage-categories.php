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
$statement = $admin->selectAllCategories();
$result = $statement->get_result();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>ADMINISTRATION | CATEGORY MANAGEMENT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap style -->
    <link id="callCss" rel="stylesheet" href="themes/bootshop/bootstrap.min.css" media="screen"/>
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
    <style type="text/css" id="enject">
      a{
        display: inline-block;
      }
      .hiddenClass {
        display: none;
      }
    </style>
    <script src="./jquery-3.1.1.js">
    </script>
    <script type="text/javascript">
      $(function() {
        $('#editProductRow').addClass('hiddenClass');
        $('.table').on('click','input', function(event) {
          clickedButton = event.target;
          if ($(clickedButton).attr('type') === "button" && $(clickedButton).attr('name') === "deleteCategory") {
            var $category_id = $(clickedButton).parent().parent().children(':first').text();
            console.log($category_id);
            myAjax = $.ajax({
              url: 'processcategoriesajax.php',
              type: 'POST',
              data: {categoryToDelete: $category_id}
            })
            .done(function(data) {
              console.log("success");
              if (data === "success") {
                $(clickedButton).parent().parent().remove();
              }
            })
            .fail(function() {
              console.log("error");
            })
          }
          if ($(clickedButton).attr('type') === "button" && $(clickedButton).attr('name') === "newCategory") {
            var $newcategory_name = $(clickedButton).parent().parent().children(':nth-child(2)').children('input').val();
            var $newcategory_parentid = $(clickedButton).parent().parent().children(':nth-child(3)').children('select').val();
            myAjax2 = $.ajax({
              url: 'processcategoriesajax.php',
              type: 'POST',
              data: {addCategory: 'true',
                     addCategoryName: $newcategory_name,
                     addCategoryParentId: $newcategory_parentid }
            })
            .done(function(data) {
              location.reload();
            })
            .fail(function() {
              console.log("error");
            });
          }
          if ($(clickedButton).attr('type') === "button" && $(clickedButton).attr('name') === "editCategory") {
            $('#editProductRow').removeClass('hiddenClass');
            $('#newProductRow').css('display', 'none');
            categoryBeingEdited = $(clickedButton).parent().parent().children(':nth-child(1)').text();
            $('select:last').focus();
            setTimeout(function() {
              $('select:last').delay(250).val($("option:contains('"+$(clickedButton).parent().parent().children(':nth-child(3)').text()+"')").val());
            }, 500);
            $('#editCategoryTextbox').focus();
            $('#editCategoryTextbox').val($(clickedButton).parent().parent().children(':nth-child(2)').text());
          }
          if ($(clickedButton).attr('type') === "button" && $(clickedButton).attr('name') === "updateCategory") {
            $updatecategory_name = $(clickedButton).parent().parent().children(':nth-child(2)').children('input').val();
            $updatecategory_parentid = $('.parentCategoryList:last').val();
            myAjax2 = $.ajax({
              url: 'processcategoriesajax.php',
              type: 'POST',
              data: {updateCategory: 'true',
                     updateCategoryId: categoryBeingEdited,
                     updateCategoryName: $updatecategory_name,
                     updateCategoryParentId: $updatecategory_parentid, }
            })
            .done(function(data) {
              location.reload();
            })
            .fail(function() {
            });

          }
        });
        $('.parentCategoryList').on('focus', function(event) {
          myAjax3 = $.ajax({
            url: 'processcategoriesajax.php',
            type: 'POST',
            data: {requestCategories: 'true'}
          })
          .done(function(data) {
            data = JSON.parse(data);
            $(event.target).children().remove();
            newOption = document.createElement('option');
            $(newOption).val(0);
            $(newOption).text("Main Category");
            $(event.target).append(newOption);
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
      <li><a href="adminindex.php">Home</a> <span class="divider">/</span></li>
      <li><a href="admin-manage-categories.php">Category Management</a>
      </ul>
      <div class="">
        <h1>Category Management</h1>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Parent Category</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
            for ($i = 0; $i < $result->num_rows; $i++) {
              $row = $result->fetch_assoc();
              echo '<tr>';
              echo '<th scope="row">'.$row['category_id'].'</th>';
              echo '<td>'.$row['category_name'].'</td>';
              echo '<td>';
              if ($row['parent_cat_id'] == 0) {
                echo "Main Category";
              } else {
                $category->id = $row['parent_cat_id'];
                $subQueryResult = $category->getById();
                if ($subQueryResult->num_rows>0) {
                    $row = $subQueryResult->fetch_array();
                    echo $row[0];
                }
              }
              echo '</td>';
              echo '<td><input type="button" class="btn btn-success" name="editCategory" value="Edit">&nbsp;';
              echo '<input type="button" class="btn btn-danger" name="deleteCategory" value="Delete"></td>';
              echo '</tr>';
            }
            ?>
            <tr id="newProductRow">
              <td></td>
              <td><input type="text" name="newCategoryName" value="" placeholder="Category Name"></td>
              <td>
                <select class="parentCategoryList" name = "ParentCategory" class="selectpicker">
                </select>
              </td>
              <td><input type="button" class="btn btn-primary" name="newCategory" value="Add"></td>
            </tr>
            <tr id="editProductRow">
              <td></td>
              <td><input id="editCategoryTextbox" type="text" name="editCategoryName" value="" placeholder="Category Name"></td>
              <td>
                <select class="parentCategoryList" name = "ParentCategory" class="selectpicker">
                </select>
              </td>
              <td><input type="button" class="btn btn-primary" name="updateCategory" value="Update Data"></td>
            </tr>
          </tbody>
        </table>
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
