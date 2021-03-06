


<?php
session_start();
if(isset($_SESSION['user_name'])) {
 	header('Location:index.php');
}
if (isset($_SESSION['loggedInAdmin'])) {
	header('Location:adminindex.php');
}
?>

<!DOCTYPE html>
<htmllang="en">
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
  		<a <?php if(!isset($_SESSION['user_name'])) { echo 'style="display: none;"';} ?>
   href="product_summary.php"><span class="btn btn-mini btn-primary"><i class="icon-shopping-cart icon-white"></i> [ <?php echo $cart_number; ?> ] Items in your cart </span> </a>
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
		<form class="form-inline navbar-search" method="post" action="products.php" >
		<input id="srchFld" class="srchTxt" type="text" />
		  <select class="srchTxt">
			<option>All</option>
			<option>CLOTHES </option>
			<option>FOOD AND BEVERAGES </option>
			<option>HEALTH & BEAUTY </option>
			<option>SPORTS & LEISURE </option>
			<option>BOOKS & ENTERTAINMENTS </option>
		</select>
		  <button type="submit" id="submitButton" class="btn btn-primary">Go</button>
    </form>
    <ul id="topMenu" class="nav pull-right">
	<!-- <li class=""><a href="special_offer.php">Specials Offer</a></li>
	 <li class=""><a href="normal.php">Delivery</a></li>-->
	 <li class=""><a href="contact.php">Contact</a></li>
	 <li class="">


	</li>
    </ul>
  </div>
</div>
</div>
</div>
<!-- Header End====================================================================== -->
<div id="mainBody">
	<div class="container">
	<div class="row">
<!-- Sidebar ==================================================
	<div id="sidebar" class="span3">
		<div class="well well-small"><a id="myCart" href="product_summary.php"><img src="themes/images/ico-cart.png" alt="cart">3 Items in your cart  <span class="badge badge-warning pull-right">$155.00</span></a></div>
		<ul id="sideManu" class="nav nav-tabs nav-stacked">
			<li class="subMenu open"><a> ELECTRONICS [230]</a>
				<ul>
				<li><a class="active" href="products.php"><i class="icon-chevron-right"></i>Cameras (100) </a></li>
				<li><a href="products.php"><i class="icon-chevron-right"></i>Computers, Tablets & laptop (30)</a></li>
				<li><a href="products.php"><i class="icon-chevron-right"></i>Mobile Phone (80)</a></li>
				<li><a href="products.php"><i class="icon-chevron-right"></i>Sound & Vision (15)</a></li>
				</ul>
			</li>
			<li class="subMenu"><a> CLOTHES [840] </a>
			<ul style="display:none">
				<li><a href="products.php"><i class="icon-chevron-right"></i>Women's Clothing (45)</a></li>
				<li><a href="products.php"><i class="icon-chevron-right"></i>Women's Shoes (8)</a></li>
				<li><a href="products.php"><i class="icon-chevron-right"></i>Women's Hand Bags (5)</a></li>
				<li><a href="products.php"><i class="icon-chevron-right"></i>Men's Clothings  (45)</a></li>
				<li><a href="products.php"><i class="icon-chevron-right"></i>Men's Shoes (6)</a></li>
				<li><a href="products.php"><i class="icon-chevron-right"></i>Kids Clothing (5)</a></li>
				<li><a href="products.php"><i class="icon-chevron-right"></i>Kids Shoes (3)</a></li>
			</ul>
			</li>
			<li class="subMenu"><a>FOOD AND BEVERAGES [1000]</a>
				<ul style="display:none">
				<li><a href="products.php"><i class="icon-chevron-right"></i>Angoves  (35)</a></li>
				<li><a href="products.php"><i class="icon-chevron-right"></i>Bouchard Aine & Fils (8)</a></li>
				<li><a href="products.php"><i class="icon-chevron-right"></i>French Rabbit (5)</a></li>
				<li><a href="products.php"><i class="icon-chevron-right"></i>Louis Bernard  (45)</a></li>
				<li><a href="products.php"><i class="icon-chevron-right"></i>BIB Wine (Bag in Box) (8)</a></li>
				<li><a href="products.php"><i class="icon-chevron-right"></i>Other Liquors & Wine (5)</a></li>
				<li><a href="products.php"><i class="icon-chevron-right"></i>Garden (3)</a></li>
				<li><a href="products.php"><i class="icon-chevron-right"></i>Khao Shong (11)</a></li>
			</ul>
			</li>
			<li><a href="products.php">HEALTH & BEAUTY [18]</a></li>
			<li><a href="products.php">SPORTS & LEISURE [58]</a></li>
			<li><a href="products.php">BOOKS & ENTERTAINMENTS [14]</a></li>
		</ul>

	</div>
Sidebar end=============================================== -->
	<div class="span12">
    <ul class="breadcrumb">
		<li><a href="index.php">Home</a> <span class="divider">/</span></li>
		<li class="active">Login</li>
    </ul>
	<h3> Login</h3>
	<hr class="soft"/>

	<div class="row">
		<div class="span5">
			<div class="well">
        <h5>Admin Login</h5>
			<form method="post" action="LoginControl.php">
			  <div class="control-group">
			  <label class="control-label" for="inputEmail12">Email</label>
			  <div class="controls">
			    <input class="span3"  type="text" id="inputEmail2" placeholder="Email" name="email_admin">
			  </div>
			  </div>
			  <div class="control-group">
			  <label class="control-label" for="inputPassword2">Password</label>
			  <div class="controls">
			    <input type="password" class="span3"  id="inputPassword2" placeholder="Password" name="password_admin">
			  </div>
			  </div>
			  <div class="control-group">
			  <div class="controls">
			    <input type="submit" class="btn" name="SignAdmin" value="Sign in"> </button> <a href="forgetpass.php">Forget password?</a>
			    <?php if(isset($_GET['adminerror']))
			      echo "<br/>Invalid Email OR Password";
			    ?>
			  </div>
			  </div>
			</form>
		</div>
		</div>
		<div class="span2"> &nbsp;</div>
		<div class="span5">
			<div class="well">
			<h5>User Login</h5>
			<form method="post" action="LoginControl.php">
			  <div class="control-group">
				<label class="control-label" for="inputEmail1">Email</label>
				<div class="controls">
				  <input class="span3"  type="text" id="inputEmail1" placeholder="Email" name="email_user">
				</div>
			  </div>
			  <div class="control-group">
				<label class="control-label" for="inputPassword1">Password</label>
				<div class="controls">
				  <input type="password" class="span3"  id="inputPassword1" placeholder="Password" name="password_user">
				</div>
			  </div>
			  <div class="control-group">
				<div class="controls">
				  <input type="submit" class="btn" name="SignUser" value="Sign in"> </button> <a href="forgetpass.php">Forget password?</a>
				  <?php if(isset($_GET['error']))
				  	echo "<br/>Invalid Email OR Password";
				  ?>
				</div>
			  </div>
			</form>
		</div>
		</div>
	</div>

</div>
</div></div>
</div>
<!-- MainBody End ============================= -->
<!-- Footer ================================================================== -->
<div  id="footerSection">
<div class="container">
	<div class="row">
		<div class="span3">
		<?php
		if(isset($_SESSION['user_name']))
		{
			echo '<h5>ACCOUNT</h5>';
			echo '<a href="personalInformation.php">YOUR ACCOUNT</a>';// //////////////_ profile.php
			echo '<a href="product_summary.php">YOUR SHOPPING CART</a>';
			echo '<a href="index.php">HOME</a>';
			echo '<a href="logout.php">LOGOUT</a>';
		}
			?>
		 </div>
		<div class="span3">
		<?php if(!isset($_SESSION['user_name']))
			{
			echo '<h5>INFORMATION</h5>';

			echo '<a href="register.php">REGISTRATION</a> ';
			echo '<a href="login.php">LOGGING IN</a> ';
		}
			?>

		 </div>

		<div id="socialMedia" class="span3 pull-right">
			<h5>SOCIAL MEDIA </h5>
			<a href="https://www.facebook.com/"><img width="60" height="60" src="themes/images/facebook.png" title="facebook" alt="facebook"/></a>
			<a href="https://twitter.com/twitter?lang=ar"><img width="60" height="60" src="themes/images/twitter.png" title="twitter" alt="twitter"/></a>
			<a href="https://www.youtube.com"><img width="60" height="60" src="themes/images/youtube.png" title="youtube" alt="youtube"/></a>
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
