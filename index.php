<?php
session_start();
if (isset($_SESSION['loggedInAdmin'])) {
	header('Location:adminindex.php');
}
require 'config.php';
require 'categoryclass.php';
require 'productclass.php';

$user_credit = 0;
$cart_number = 0;
if(isset($_SESSION['user_name'])) {
	require 'cart.php';
	$uid = (int)$_SESSION['user_id'];
	$user_credit  = getCreditById($uid, $con);
	$cart_number = getCartNumById($uid, $con);
}

$products=productclass::getAll();
$catname;
$catid;
$statement = categoryclass::getCatById();
$statement->bind_result($catname, $catid);
$statement->store_result();

$search=categoryclass::searchSubCat();

?>
﻿<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Bootshop online Shopping cart</title>
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
	<style type="text/css" id="enject"></style>


  </head>
<body>
<div id="header">
<div class="container">
<div id="welcomeLine" class="row">
	<div class="span6">Welcome!<strong> <?php if(isset($_SESSION['user_name'])) echo "". $_SESSION['user_name']."";?></strong></div>
	<div class="span6">
		<div class="pull-right">
			<span <?php if(!isset($_SESSION['user_name'])) { echo 'style="display: none;"';} ?>
			class="btn btn-mini"><?php echo '$ '.$user_credit;?></span>
			<a <?php if(!isset($_SESSION['user_name'])) { echo 'style="display: none;"';} ?> href="product_summary.php">
				<span class="btn btn-mini btn-primary">
					<i class="icon-shopping-cart icon-white"></i>
					[ <?php echo $cart_number; ?> ] Items in your cart
				</span>
			</a>
		</div>
	</div>
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
		<?php
    	echo'<form class="form-inline navbar-search" method="get" action="search.php" >';
    	echo '<input id="srchFld" name="prices" class="srchTxt" type="number" />';
      echo '<select id="catFld" name="category" class="srchTxt">';
      echo '<option>---</option>';
      for ($i = 0; $i < $search->num_rows; $i++) {
    		$row = $search->fetch_assoc();
       	echo '<option value='.$row['category_id'].'>'.$row['category_name'].'</option>';
    	}
    	echo '</select>';
      echo'<button type="submit" id="submitButton" class="btn btn-primary"> Go</button>';
      echo'</form>'; ?>
    <ul id="topMenu" class="nav pull-right">
	 <!--<li class=""><a href="special_offer.php">Specials Offer</a></li>
	 <li class=""><a href="normal.php">Delivery</a></li>-->
	 <li class=""><a href="contact.php">Contact</a></li>
   	<?php if(!isset($_SESSION['user_name']))
   			{echo "<li class=''><a href='register.php' style='padding-right:0'><span class='btn btn-large btn-success'>Register</span></a></li>
	 <li class=''>
	 <a href='login.php' style='padding-right:0'><span class='btn btn-large btn-success'>Login</span></a>";
	}
	 else
	 	echo"<a href='logout.php' style='padding-right:0'><span class='btn btn-large btn-success'style='margin-top:10px;
'>Logout</span></a>";
   	?>
	</li>
    </ul>
  </div>
</div>
</div>
</div>
<!-- Header End====================================================================== -->

</div>
<div id="mainBody">
	<div class="container">
	<div class="row">
<!-- Sidebar ================================================== -->
	<div id="sidebar" class="span3">
		<div class="well well-small">
			<a id="myCart" href="product_summary.php">
				<img src="themes/images/ico-cart.png" alt="cart"> <?php echo $cart_number; ?> Items in your cart
				<span class="badge badge-warning pull-right"> <?php echo '$ '.$user_credit; ?> </span>
			</a>
		</div>
		<?php
			echo	'<ul id="sideManu" class="nav nav-tabs nav-stacked">';
			for ($i=0; $i < $statement->num_rows ; $i++) {
				$statement->fetch();
				echo '<li class="subMenu open"><a> '. $catname.'</a>';
				$result = categoryclass::getSubCategories($catid);
				for ($j=0; $j < $result->num_rows; $j++) {
					$row = $result->fetch_assoc();
					echo '<ul';
					if ($i>0) {echo ' style="display:none"';}
					echo '>';
					echo '<li><a href="products.php?category_id='.$row['category_id'].'" id= '.$row['category_id'].'><i class="icon-chevron-right"></i>'.$row['category_name'].'</a></li>';
					echo '</ul>';
				}
				echo '</li>';
			}
			echo '</ul>'; ?>
	</div>
<!-- Sidebar end=============================================== -->
		<div class="span9">
		<?php
		echo '<h4>Latest Products</h4>';
			echo ' <ul class="thumbnails">';
			  for ($i = 0; $i < $products->num_rows; $i++) {
        		$row = $products->fetch_assoc();
				echo'<li class="span3">';
				  echo'<div class="thumbnail">';
					echo '<a href="product_details.php?product_id='.$row['product_id'].'&&category_id='.$row['subcat_id'].'"><img src="'.$row['pic_path'].'" /></a>';
					echo'<div class="caption">';
					  // <h5>Product name</h5>
					   echo '<h5>'.$row['product_name'].'</h5>';
					 //  <p>
						// Lorem Ipsum is simply dummy text.
					 //  </p>
					  echo '<p>'.$row['description'].'</p>';
					 echo'<h4 style="text-align:center">
					 	<a class="btn" href="product_details.php?product_id='.$row['product_id'].'&&category_id='.$row['subcat_id'].'">
							 <i class="icon-zoom-in"></i>
						</a>';
					 	echo'<a ';
						if(!isset($_SESSION['user_name'])) { echo 'style="display: none;"';}
						echo ' class="btn" href="addToCart.php?sourcePage=index.php&addCartId='.$row['product_id'].'">Add to <i class="icon-shopping-cart"></i></a>';
					 	echo '<a class="btn btn-primary" href="#"> '.$row['price'].'</a>';
					 	echo'</h4>';
					echo '</div>';
				  echo '</div>';
				echo '</li>';
			}
			 echo '</ul>';

?>
		</div>
		</div>
	</div>
</div>
<!-- Footer ================================================================== -->
	<div  id="footerSection">
	<div class="container">
		<div class="row">
			<div class="span3">
				<h5>ACCOUNT</h5>
				<a href="login.php">YOUR ACCOUNT</a>
				<a href="login.php">PERSONAL INFORMATION</a>
				<a href="login.php">ADDRESSES</a>
				<a href="login.php">DISCOUNT</a>
				<a href="login.php">ORDER HISTORY</a>
			 </div>
			<div class="span3">
				<h5>INFORMATION</h5>
				<a href="contact.php">CONTACT</a>
				<a href="register.php">REGISTRATION</a>
				<a href="legal_notice.php">LEGAL NOTICE</a>
				<a href="tac.php">TERMS AND CONDITIONS</a>
				<a href="faq.php">FAQ</a>
			 </div>
			<div class="span3">
				<h5>OUR OFFERS</h5>
				<a href="#">NEW PRODUCTS</a>
				<a href="#">TOP SELLERS</a>
				<a href="special_offer.php">SPECIAL OFFERS</a>
				<a href="#">MANUFACTURERS</a>
				<a href="#">SUPPLIERS</a>
			 </div>
			<div id="socialMedia" class="span3 pull-right">
				<h5>SOCIAL MEDIA </h5>
				<a href="#"><img width="60" height="60" src="themes/images/facebook.png" title="facebook" alt="facebook"/></a>
				<a href="#"><img width="60" height="60" src="themes/images/twitter.png" title="twitter" alt="twitter"/></a>
				<a href="#"><img width="60" height="60" src="themes/images/youtube.png" title="youtube" alt="youtube"/></a>
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

	<!-- Themes switcher section ============================================================================================= -->
<div id="secectionBox">
<link rel="stylesheet" href="themes/switch/themeswitch.css" type="text/css" media="screen" />
<script src="themes/switch/theamswitcher.js" type="text/javascript" charset="utf-8"></script>
	<div id="themeContainer">
	<div id="hideme" class="themeTitle">Style Selector</div>
	<div class="themeName">Oregional Skin</div>
	<div class="images style">
	<a href="themes/css/#" name="bootshop"><img src="themes/switch/images/clr/bootshop.png" alt="bootstrap business templates" class="active"></a>
	<a href="themes/css/#" name="businessltd"><img src="themes/switch/images/clr/businessltd.png" alt="bootstrap business templates" class="active"></a>
	</div>
	<div class="themeName">Bootswatch Skins (11)</div>
	<div class="images style">
		<a href="themes/css/#" name="amelia" title="Amelia"><img src="themes/switch/images/clr/amelia.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="spruce" title="Spruce"><img src="themes/switch/images/clr/spruce.png" alt="bootstrap business templates" ></a>
		<a href="themes/css/#" name="superhero" title="Superhero"><img src="themes/switch/images/clr/superhero.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="cyborg"><img src="themes/switch/images/clr/cyborg.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="cerulean"><img src="themes/switch/images/clr/cerulean.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="journal"><img src="themes/switch/images/clr/journal.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="readable"><img src="themes/switch/images/clr/readable.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="simplex"><img src="themes/switch/images/clr/simplex.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="slate"><img src="themes/switch/images/clr/slate.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="spacelab"><img src="themes/switch/images/clr/spacelab.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="united"><img src="themes/switch/images/clr/united.png" alt="bootstrap business templates"></a>
		<p style="margin:0;line-height:normal;margin-left:-10px;display:none;"><small>These are just examples and you can build your own color scheme in the backend.</small></p>
	</div>
	<div class="themeName">Background Patterns </div>
	<div class="images patterns">
		<a href="themes/css/#" name="pattern1"><img src="themes/switch/images/pattern/pattern1.png" alt="bootstrap business templates" class="active"></a>
		<a href="themes/css/#" name="pattern2"><img src="themes/switch/images/pattern/pattern2.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern3"><img src="themes/switch/images/pattern/pattern3.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern4"><img src="themes/switch/images/pattern/pattern4.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern5"><img src="themes/switch/images/pattern/pattern5.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern6"><img src="themes/switch/images/pattern/pattern6.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern7"><img src="themes/switch/images/pattern/pattern7.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern8"><img src="themes/switch/images/pattern/pattern8.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern9"><img src="themes/switch/images/pattern/pattern9.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern10"><img src="themes/switch/images/pattern/pattern10.png" alt="bootstrap business templates"></a>

		<a href="themes/css/#" name="pattern11"><img src="themes/switch/images/pattern/pattern11.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern12"><img src="themes/switch/images/pattern/pattern12.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern13"><img src="themes/switch/images/pattern/pattern13.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern14"><img src="themes/switch/images/pattern/pattern14.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern15"><img src="themes/switch/images/pattern/pattern15.png" alt="bootstrap business templates"></a>

		<a href="themes/css/#" name="pattern16"><img src="themes/switch/images/pattern/pattern16.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern17"><img src="themes/switch/images/pattern/pattern17.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern18"><img src="themes/switch/images/pattern/pattern18.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern19"><img src="themes/switch/images/pattern/pattern19.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern20"><img src="themes/switch/images/pattern/pattern20.png" alt="bootstrap business templates"></a>

	</div>
	</div>
</div>
</body>
</html>
