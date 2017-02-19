<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'root';
$dbname = 'phpproject';

$success=true;
$con = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
if($con->connect_errno)
{
	echo "error connection to DB".$con->connect_error."<br>" ;
	$success=false;
}
?>
