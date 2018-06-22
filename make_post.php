<?php
	session_start();
	include('connection.php');

	$uname = $_SESSION['uname'];

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		if (isset($_POST['posted'])) {
			$post  = mysqli_real_escape_string($dbc, $_POST['post']);
			$tag   = mysqli_real_escape_string($dbc, $_POST['tag']);

			$image      = $_FILES['image'];
			$name       = $_FILES['image']['name'];
			$temp_name  = $_FILES['image']['tmp_name'];
			$newname = $name; 
			//print_r($_FILES); 
			$location = realpath(dirname(__FILE__)).'/images/'.basename($name); 
			$image_path = realpath(dirname(__FILE__)).'/images/';   
			$extention = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

			if (!empty($name)) {
				if(file_exists($location)){
				    $increment = 0;
				    list($name, $extention) = explode('.', $name);
				    while(file_exists($location)) {
				        $increment++;
				        $location = realpath(dirname(__FILE__)).'/images/'.$name. $increment . '.' . $extention;
				        $newname = $name. $increment . '.' . $extention;
				    }
				 } 
			}

			mysqli_query($dbc, "INSERT INTO post(username, post, image, tag) VALUES('$uname', '$post', '$newname', '$tag')");

			if(isset($newname)){
			    if(!empty($newname)){    
				    if(move_uploaded_file($_FILES['image']['tmp_name'], $location) && is_writable($location)){
				        //echo 'File uploaded successfully';
				    }
				    else{
				        //echo "Failed to move...";
				    }
				}
			}
		    //  else {
		    //    echo 'You should select a file to upload !!';
		   // }

			$registered = mysql_affected_rows();
			$myQuery = "SELECT * FROM post WHERE username='".$uname."'";
			$r=  mysqli_query($dbc, $myQuery); // or die($myQuery."<br/><br/>".mysql_error());
			if (!$r) {
				echo "Error: failure. ERROR: ".mysqli_error($dbc);
				echo "Debugging errno: ".mysqli_errno($dbc).PHP_EOL;
				echo "Debugging error : ".mysqli_error($dbc).PHP_EOL;
				exit;
			}
			$row = mysqli_fetch_array($r, MYSQLI_BOTH);
			$_SESSION['id'] = $row['id'];
			header('Location: dashboard.php');
		}
	}else {
		echo "No form has been submitted";
	}

	$stmt->close();
	$dbc->close();

	//$res = mysqli_query($dbc, "SELECT * FROM registration");

	/*while ($row = mysqli_fetch_array($res)) {
		echo $row['username']."/".$row['age'];
	}*/
?>
