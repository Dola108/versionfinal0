<?php  
	include('connection.php');
	session_start();

    if (empty($_SESSION['uname'])) {
    	header('Location: homepage.php');
      	exit();
    }
    
    $uname = $_GET['un'];
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $uname; ?></title>
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<link rel="stylesheet" type="text/css" href="dashboard.css">
	<style type="text/css">
		.avatar {
		    position: relative;
		    align-self: center;
		    margin-left: auto;
		    margin-right: auto;
		    object-fit: cover;
		    height: 130px;
		    max-width: 130px;
		    border-color: #4CAF50;
		    border-style: solid;
		    border-width: 5px;
		    border-radius: 50%;
		}
		li.lsa {
		    float: left;
		}

		li.lsa a {
		    display: block;
		    color: white;
		    text-align: center;
		    padding: 14px 30px;
		    text-decoration: none;
		    font-family: sans-serif;
		    font-size: 15.5px;
		}

		li.lsa a:hover {
		    color: #5DD35B;
		}
	</style>
</head>
<body style="background-image: url('jjj.jpg'); overflow: hidden">
	<nav id="myHeader" style="margin-left: -9px; margin-right: -9px; margin-top: -8px; position: fixed; top: 8px; width: 100%;">
	    <ul class="ls">
	    	<?php
	    		$myQuery = "SELECT * FROM registration WHERE username='".$_SESSION['uname']."'";
				$r=  mysqli_query($dbc, $myQuery);

				$row = mysqli_fetch_array($r, MYSQLI_BOTH);
				if (!empty($row['avatar'])) {
					echo "<li class='ls'><img src='images/".$row['avatar']."' class='avatar' width='32px' onmouseover='focImg(this)' onmouseout='unfocImg(this)' style='margin-left: 15px; margin-top: 5px; border-width:2px; height:32px !important;'></li>";
				}
			?>
	        <li class="lsa"><a href="profile.php">Profile</a></li>
	        <li class="lsa"><a href="Dashboard.php" id="searchbox">Dashboard</a></li>
	        <li class="lsa"><a href="Tagboard.php?val=Tags">Tagboard</a></li>
	    </ul>
	<button type="button" id="logout" class="button3"  onclick="window.location.href = 'logout.php'" 
													   value="check" style="															        
													   	   margin-right: 5%;
		        										   padding: 6px 16px;
		        										   font-size: 14px;
		        										   margin-top: -3%;">Log out</button>
	</nav>

	<div class="dash">
		<h1>User Info</h1>
	</div>

	<div class="container" style="height: 1200px; top: 180px!important;">
		<p><br></p>
		<h2 style="text-align: center; margin-left:auto; margin-right:auto;">Info</h2>
		<div class="postbox" style="height: 300px;">
			<br>
			<div>
				<?php
					$myQuery = "SELECT * FROM registration WHERE username='".$_GET['un']."'";
					$r=  mysqli_query($dbc, $myQuery);// or die($myQuery."<br/><br/>".mysqli_error($dbc));
					if (!$r) {
						echo "Error: failure. ERROR: ".mysqli_error($dbc);
						echo "Debugging errno: ".mysqli_errno($dbc).PHP_EOL;
						echo "Debugging error : ".mysqli_error($dbc).PHP_EOL;
						exit;
					}

					$row = mysqli_fetch_array($r, MYSQLI_BOTH);
					$age = $row['age'];
					$email = $row['email'];
					$gender = $row['gender'];
					if (empty($row['avatar'])) {
						echo "<img src='blankavatar.png' class='avatar'>";
					}
					else {
						echo "<img src='images/".$row['avatar']."' class='avatar'>";
					}
				?>
			</div>
			<label for="Username"><b style="font-family: Helvetica Neue; font-size: 18px; color: #acacac;">Username : </b></label>
				<?php echo "<b style='font-size: 18px; color:#eaeaea;'>".$uname."</b>"; ?><br>

			<label for="email"><b style="font-family: Helvetica Neue; font-size: 18px; color: #acacac;">Email : </b></label>
				<?php echo "<b style='font-size: 18px; color:#eaeaea;'>".$email."</b>"; ?><br>

			<label for="dtb"><b style="font-family: Helvetica Neue; font-size: 18px; color: #acacac;">Age : </b></label>
				<?php echo "<b style='font-size: 18px; color:#eaeaea;'>".$age."</b>"; ?><br>

			<label for="dtb"><b style="font-family: Helvetica Neue; font-size: 18px; color: #acacac;">Gender : </b></label>
				<?php echo "<b style='font-size: 18px; color:#eaeaea;'>".$gender."</b>"; ?><br>
		</div>
	</div>
	<footer style="margin-top: 1150px;">Copyright &copy; 1tag.com</footer>
</body>
</html>