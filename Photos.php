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
	<title>Settings</title>
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<link rel="stylesheet" type="text/css" href="dashboard.css">
	<style type="text/css">
		div.dashh {
			position: absolute;
			margin-top: 0px;
			width: 68.7%;
			z-index: -1;
			margin-left: 12.9%;
			margin-right: 15%;
			overflow: auto;
		    background-image: url('full.jpg');
			margin: 5px #333;
			padding: 2em;
		}
		.field {
			position: absolute;
			vertical-align: middle;
			margin-left: 15%;
			margin-right: auto;
		    width: 70%; 
		    height: 70%; 
		    overflow-y: auto;
		    background-color: rgb(0,0,0); 
		    background-color: rgba(0,0,0,0.7); 
		}
		label.del a {
			text-decoration: none;
			font-size: 18px;
			position: absolute;
			font-family: Helvetica Neue;
			color: #acacac;
		}
		label.del a:hover {
			color: white;
		}
				/* The Modal (background) */
		.modal {
		    display: none; /* Hidden by default */
		    position: fixed; /* Stay in place */
		    z-index:  9999 !important; /* Sit on top */
		    padding-top: 100px; /* Location of the box */
		    left: 0;
		    top: 5%;
		    width: 100%; /* Full width */
		    height: 100%; /* Full height */
		    overflow: auto; /* Enable scroll if needed */
		    background-color: rgb(0,0,0); /* Fallback color */
		    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
		}

		/* Modal Content (image) */
		.modal-content {
		    margin: auto;
		    display: block;
		    width: 80%;
		    max-width: 700px;
		}

		/* Add Animation */
		.modal-content{    
		    -webkit-animation-name: zoom;
		    -webkit-animation-duration: 0.6s;
		    animation-name: zoom;
		    animation-duration: 0.6s;
		}
		/* The Close Button */
		.close {
		    position: absolute;
		    top: 15px;
		    right: 35px;
		    color: #f1f1f1;
		    font-size: 40px;
		    font-weight: bold;
		    transition: 0.3s;
		}

		.close:hover,
		.close:focus {
		    color: #bbb;
		    text-decoration: none;
		    cursor: pointer;
		}

		/* 100% Image Width on Smaller Screens */
		@media only screen and (max-width: 700px){
		    .modal-content {
		        width: 100%;
		    }
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
<body style="background-image: url('jjj.jpg');">
	<nav style="margin-left: -9px; margin-right: -9px; margin-top: -8px; position: fixed; z-index: 1; top: 8px; width: 100%;">
	    <ul class="ls">
	    	<?php
	    		$myQuery = "SELECT * FROM registration WHERE username='".$_SESSION['uname']."'";
				$r=  mysqli_query($dbc, $myQuery);

				$row = mysqli_fetch_array($r, MYSQLI_BOTH);
				if (!empty($row['avatar'])) {
					echo "<li class='lsa'><img href=\"profile.php\" src='images/".$row['avatar']."' class='avatar' width='32px' onmouseover='focImg(this)' onmouseout='unfocImg(this)' style='margin-left: 15px; margin-top: 5px;cursor:pointer; border-width:2px; border-color: #4CAF50; border-style: solid; border-radius:50%; height:32px !important;'></li>";
				}
    			$uname = $_GET['un'];
			?>
	        <li class="lsa"><a href="profile.php" style="font-size: 17px!important;">Profile</a></li>
	        <li class="lsa"><a href="Dashboard.php" style="font-size: 17px!important;">Dashboard</a></li>
	        <li class="lsa"><a href="Tagboard.php?val=Tags" style="font-size: 17px!important;">Tagboard</a></li>
	    </ul>
	<button type="button" id="logout" class="button3"  onclick="window.location.href = 'logout.php'" 
													   value="check" style="															        
													   	   margin-right: 5%;
		        										   padding: 6px 16px;
		        										   font-size: 14px;
		        										   margin-top: -3%;">Log out</button>
	</nav>

	<div class="dashh" style="width: 948px;">
		<h1 style="font-size: 44px;"><?php echo $uname; ?></h1>
	</div>

	<div class="container" style="height: 190%; top: 180px!important;">
		<p><br></p>
		<h2 style="text-align: center; margin-left:auto; margin-right:auto; margin-top:-10px;">All Photos</h2>
			<div class="field">
				<form class="modal-content" style="background-color: transparent;" action="edit.php" enctype="multipart/form-data" method="post">
				    <div style="background-color: transparent; margin-left: 50px; margin-top: 60px; margin-right: 0; margin-bottom: 0; width: 500px; margin-left: 40px;">
				    <?php
				    	$myQuery ="SELECT * FROM post WHERE username='".$uname."'ORDER BY time DESC";
						$ro=  mysqli_query($dbc, $myQuery);//or die($myQuery."<br/><br/>".mysql_error());
						$num_row = mysqli_num_rows($ro);

						while($num_row!=0) {
							$rw = mysqli_fetch_array($ro, MYSQLI_BOTH);
							$image = $rw['image'];
							if (!empty($image)) {
								echo "<img src='images/".$rw['image']."' id='imgg' width='110px' height='110px' onclick='view(this)' onmouseover='focImg(this)' onmouseout='unfocImg(this)' style='align-self: center; object-fit: cover;
									border-color: #333;
								    border-style: solid;
								    border-width: 4px;
								    border-radius: 3px;'>";
							}

							echo "<div id=\"myModal\" class=\"modal\">
							  <span class=\"close\">&times;</span>
							  <img src='images/".$rw['image']."' style='max-height: 480px; width: auto; margin-top:-20px;' class=\"modal-content\" id='ikg'>
							</div>";
							$num_row--;
						}
					?>
				    </div>
				</form>
			</div>
	</div>
	<footer style="float: bottom!important;">Copyright &copy; 1tag.com</footer>
	<script type="text/javascript">
		var del = document.getElementById('del');
		del.onclick = function() {
			if(confirm("Delete account?")) {
				event.preventDefault();
				document.location.href = "delete.php";
			}
			else {
				event.preventDefault();
				window.location.href = "profile.php";
			}
		}
		function focImg(x) {
		    x.style.opacity = "0.5";
		}

		function unfocImg(x) {
		    x.style.opacity = "initial";
		}
	</script>
	<script src="jquery-3.3.1.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script>
		// Get the modal
		var modal = document.getElementById('myModal');
		var img = document.getElementById('imgg');
		var modalImg = document.getElementById("ikg");
		function view(x) {
		    modal.style.display = "block";
		    modalImg.src = x.src;
		    $('body').css('overflow','hidden');
		}

		// Get the <span> element that closes the modal
		var span = document.getElementsByClassName("close")[0];

		// When the user clicks on <span> (x), close the modal
		span.onclick = function() { 
		    modal.style.display = "none";
		    $('body').css('overflow','initial');
		}
		window.onclick = function(event) {
		    if (event.target.id == 'myModal') {
		        modal.style.display = "none";
		    }
		}
	</script>
</body>
</html>