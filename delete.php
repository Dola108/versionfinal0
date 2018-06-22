<?php 
	session_start();
	include('connection.php');

	if (isset($_POST['un'])) {
		$id = $_POST['un'];
	}
	
	$namefetch = mysqli_query($dbc, "SELECT * FROM registration WHERE id='".$id."'");
	$row = mysqli_fetch_array($namefetch, MYSQLI_BOTH);
	$name = $row['avatar'];
	$uname = $row['username'];

	if (!empty($name)) {
		$location = realpath(dirname(__FILE__)).'/images/'.basename($name); 
		$image_path = realpath(dirname(__FILE__)).'/images/';   
		
		if(file_exists($location)){
		    unlink($location);
		 } 
	}

	$myQuery = "DELETE FROM registration WHERE id='".$id."'";
	$query = "DELETE FROM post WHERE username='".$uname."'";
	$query2 = "DELETE FROM comment WHERE username='".$uname."'";
	$query3 = "DELETE FROM likes WHERE username='".$uname."'";
	$query4 = "DELETE FROM reqs WHERE username='".$uname."'";
	$query5 = "DELETE FROM notifications WHERE receiver='".$uname."'";

	mysqli_query($dbc, $myQuery);
	mysqli_query($dbc, $query);
	mysqli_query($dbc, $query2);
	mysqli_query($dbc, $query3);
	mysqli_query($dbc, $query4);
	mysqli_query($dbc, $query5);

	echo "success";
?>