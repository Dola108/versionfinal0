<?php
	session_start();

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		if (isset($_POST['reg'])) {
			include('connection.php');
			$uname  = mysqli_real_escape_string($dbc, $_POST['uname']);
			$email  = mysqli_real_escape_string($dbc, $_POST['email']);
			$pass1  = mysqli_real_escape_string($dbc, $_POST['psw']);
			$pass2  = mysqli_real_escape_string($dbc, $_POST['psw2']);
			$gender = mysqli_real_escape_string($dbc, $_POST['gender']);
			$age    = mysqli_real_escape_string($dbc, $_POST['age']);

			$errors = array();

			if ($pass1 == $pass2) {
				$pass1 = password_hash($pass1, PASSWORD_DEFAULT);
				$reslt = false;

				$stmt = $dbc->prepare('SELECT * FROM registration WHERE email = ?  OR username = ?');
	            $stmt->bind_param('ss', $email, $uname); // 's' specifies the variable type => 'string'

	            $stmt->execute();

	            $result = $stmt->get_result();

	            if($result->num_rows > 0) {
				//$usercheck = "SELECT * FROM registration WHERE email='$email' OR username='$uname'";
				//$reslt = mysqli_query($dbc, $usercheck);
				//$yes = count($reslt); //yes>0?usr exists:not;
				//$rowcount=mysqli_num_rows($reslt);

				//if ($rowcount>0) {
					//redirect to homepage.php		
					//header('Location:http://localhost/fuckinFromSkratch/homepage.php');
  					if (isset($_POST['uname'])) {
						$email = null;
						session_destroy();
					}
  					$stmt->close();
                	echo "<script>
                      		alert('User already exists!!');
                            window.location.href = 'homepage.php';
                      </script>";
                    exit;
				}
				
				$avatar     = $_FILES['avatar'];
				$name       = $_FILES['avatar']['name'];  
			    $temp_name  = $_FILES['avatar']['tmp_name'];  
			    //print_r($_FILES); die();
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

			    $stmt = $dbc->prepare("INSERT INTO registration(username, email, password, age, gender, avatar) VALUES(?, ?, ?, ?, ?, ?)");
				$stmt->bind_param("sssisb", $uname, $email, $pass1, $age, $gender, $newname);
				$stmt->execute;
				
				mysqli_query($dbc, "INSERT INTO registration(username, email, password, age, gender, avatar) VALUES('$uname', '$email', '$pass1', '$age', '$gender', '$newname')");

				if(isset($newname)){
			        if(!empty($newname)){      
			            $location = realpath(dirname(__FILE__)).'/images/'.basename($newname); 
			            $image_path = realpath(dirname(__FILE__)).'/images/';    
 
			            if(move_uploaded_file($_FILES['avatar']['tmp_name'], $location) && is_writable($location)){
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
				$myQuery = "SELECT * FROM registration WHERE username='".$uname."'";
				$r=  mysqli_query($dbc, $myQuery); // or die($myQuery."<br/><br/>".mysql_error());
				$row = mysqli_fetch_array($dbc, MYSQLI_BOTH);
				$_SESSION['uname'] = $uname;
				if (strpos($uname, 'Admin') !== false) {
					header('Location: admin_page.php?uname='.$_SESSION['uname']);
					exit();
				}
				header('Location: profile.php?uname='.$_SESSION['uname']);
			}
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
