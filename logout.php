<?php  
/*	session_start();include('connection.php');
	$uname=$_GET['uname'];
	$myQuery = "SELECT * FROM registration WHERE username='".$uname."'";
	$r=  mysqli_query($dbc, $myQuery) or die($myQuery."<br/><br/>".mysql_error());
	$row = mysqli_fetch_array($dbc, "SELECT * FROM registration");
	unset($GET['uname']);
	session_unset();
	session_destroy();

	header("Location:http://localhost/fuckinFromSkratch/homepage.php");
	exit();*/
	session_start();
	include('connection.php');
	$val = $_GET["val"];
	if (isset($_SESSION['uname'])) {
		$_SESSION['uname'] = null;
	}
	unset($_SESSION['uname']);
	session_unset();
	session_destroy();
	header("Location: homepage.php");
	exit();
?>