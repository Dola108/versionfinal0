<?php
	session_start();
	include('connection.php');
	$uname = $_SESSION['uname'];

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$myQuery = "SELECT * FROM registration WHERE username='".$uname."'";

		$r=  mysqli_query($dbc, $myQuery);// or die($myQuery."<br/><br/>".mysqli_error($dbc));
		if (!$r) {
			echo "Error: failure. ERROR: ".mysqli_error($dbc);
			echo "Debugging errno: ".mysqli_errno($dbc).PHP_EOL;
			echo "Debugging error : ".mysqli_error($dbc).PHP_EOL;
			exit;
		}

		$row = mysqli_fetch_array($r, MYSQLI_BOTH);
		$existing_image = $row['avatar'];

		$avatar     = $_FILES['avatar'];
		$name       = $_FILES['avatar']['name'];  
	    $temp_name  = $_FILES['avatar']['tmp_name'];
	    //print_r($name); die();
	    $newname = $name; 
		//print_r($_FILES); 
		$location = realpath(dirname(__FILE__)).'/images/'.basename($name); 
		$image_path = realpath(dirname(__FILE__)).'/images/';   
		$extention = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
		if ($newname!="") {
			# code...
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
	    mysqli_query($dbc, "UPDATE registration SET avatar='$newname' WHERE username='".$uname."'");

				if(isset($newname)){
			        if(!empty($newname)){      
			            $location = realpath(dirname(__FILE__)).'/images/'.basename($newname); 
			            $image_path = realpath(dirname(__FILE__)).'/images/';    
 
			            if(move_uploaded_file($_FILES['avatar']['tmp_name'], $location) && is_writable($location)){
			                header('Location: profile.php');
			            }
			            else{
			            	//echo "Failed to move...";
			            }
			        }       
			    }
		
        else {
        	header('Location: account.php');
        }
	}
?>