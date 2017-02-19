<?php
session_start();
if (!isset($_SESSION['loggedInAdmin']) || empty($_SESSION['loggedInAdmin'])) {
  header('Location:login.php');
}
require 'config.php';
require 'category.php';
require_once 'admin.php';

$admin = new admin();
$statement = $admin->selectAllUsers();
$result = $statement->get_result();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>ADMINISTRATION | USER MANAGEMENT</title>
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
    <script src="jquery-3.1.1.js">
    </script>
    <script type="text/javascript">
      $(function() {
        $('.span10:first').css('display', 'none');
        $('table').on('click','input', function(event) {
          clickedButton = event.target;
          if ($(clickedButton).attr('type') === "button" && $(clickedButton).attr('name') === "deleteUser") {
            var $user_id = $(clickedButton).parent().parent().children(':first').text();
            myAjax = $.ajax({
              url: 'processuserajax.php',
              type: 'POST',
              data: {userToDelete: $user_id}
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
          <li><a href="admin-manage-users.php">User Management</a>
        </ul>
        <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Birthday</th>
            <th>Job</th>
            <th>Email</th>
            <th>Credit</th>
            <th>Address</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php
          for ($i = 0; $i < $result->num_rows; $i++) {
            $row = $result->fetch_assoc();
            echo '<tr>';
            echo '<th scope="row">'.$row['user_id'].'</th>';
            echo '<td>'.$row['user_name'].'</td>';
            echo '<td>'.$row['birthday'].'</td>';
            echo '<td>'.$row['job'].'</td>';
            echo '<td>'.$row['email'].'</td>';
            echo '<td>'.$row['credit'].'</td>';
            echo '<td>'.$row['address'].'</td>';
            echo '<td><input type="button" class="btn btn-danger" name="deleteUser" value="Delete"></td>';
            echo '</tr>';
          }
          ?>
        </tbody>
      </table>
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
