<?php
	session_start();
	include('connection.php');

	$uname = $_SESSION['uname'];
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
	} else {
		print_r($_GET['id']);
	}

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		if (isset($_POST['posted'])) {
			$text  = mysqli_real_escape_string($dbc, $_POST['texts']);
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

			mysqli_query($dbc, "INSERT INTO comments(username, texts, image, tag, post_id) VALUES('$uname', '$text', '$newname', '$tag', '$id')");

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
			$myQuery = "SELECT * FROM comments WHERE post_id='".$id."'";
			$r=  mysqli_query($dbc, $myQuery); // or die($myQuery."<br/><br/>".mysql_error());
			if (!$r) {
				echo "Error: failure. ERROR: ".mysqli_error($dbc);
				echo "Debugging errno: ".mysqli_errno($dbc).PHP_EOL;
				echo "Debugging error : ".mysqli_error($dbc).PHP_EOL;
				exit;
			}
			$row = mysqli_fetch_array($r, MYSQLI_BOTH);
			$_SESSION['id'] = $row['id'];
			header('Location: viewfull.php?id='.$id);
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
