<!DOCTYPE html>
<html>
<head>
	<head>
		<link rel="stylesheet" type="text/css" href="theme.css">
	</head>
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
	<title>1Tag</title>
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
</head>
<body>
<div id="myModal" class="modal">
	  <!-- Modal content -->
	  <div class="modal-content" style="background-image: url('3.jpg');">
	    <span onclick="document.getElementById('close').style.display='none'" class="close" title="Close Modal" style="margin-right: 2%">&times;</span>
		  <form class="modal-content" style="background-color: transparent;" action="http://localhost/proj/register.php" method="post">
		    <div style="background-color: transparent; margin-left: 50px; margin-top: -10px; margin-right: 0; margin-bottom: 0; width: 400px;">
		      <h3 style="color: #acacac; font-size: 30px; font-family: Helvetica Neue;">Sign In</h3>
		      <p style="font-family: Helvetica Neue; color: #acacac;">Please fill in this form to create an account.</p>
		      <hr>
		      <label for="Username"><b style="font-family: Helvetica Neue; color: #acacac;">Username : </b></label>
		      <input type="name" placeholder="Enter Username" name="name" required>

		      <label for="email"><b style="font-family: Helvetica Neue; color: #acacac;">Email : </b></label>
		      <input type="mail" placeholder="Enter Email" name="email" required>

		      <label for="psw"><b style="font-family: Helvetica Neue; color: #acacac;">Password : </b></label>
		      <input type="password" placeholder="Enter Password" name="psw" required>

		      <label>
		        <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px; color: #acacac;"> <b style="font-family: Helvetica Neue; color: #acacac;">Remember me</b>
		      </label>

		      <p style="font-family: Helvetica Neue; color: #acacac;">Are you not registered?<a href="#" style="color:dodgerblue">Register</a>.</p>

		      <div class="clearfix">
		        <button type="button" id="cancel" onclick="document.getElementById('myModal').style.display='none'" class="button3" style="margin-right: 5%; 
				    background-color: #333;
				    padding: 6px 16px;
				    font-size: 14px;">Cancel</button>
		        <button type="submit" class="button2" style=" padding:6px 16px; font-size: 14px;" name="login">Sign In</button>
		      </div>
		    </div>
		  </form>
	  </div>
	</div>

<div id="myReg" class="modal">
	  <!-- Modal content -->
	  <div class="modal-content" style="background-image: url('3.jpg');">
	    <span onclick="document.getElementById('close').style.display='none'" class="close" title="Close Modal" style="margin-right: 2%">&times;</span>
		  <form class="modal-content" style="background-color: transparent;" action="" method="post">
		    <div style="background-color: transparent; margin-left: 50px; margin-top: -10px; margin-right: 0; margin-bottom: 0; width: 400px;">
		      <h3 style="color: #acacac; font-size: 30px; font-family: Helvetica Neue;">Sign Up</h3>
		      <p style="font-family: Helvetica Neue; color: #acacac;">Please fill in this form to log into your account.</p>
		      <hr>
		      <label for="Username"><b style="font-family: Helvetica Neue; color: #acacac;">Username : </b></label>
		      <input type="name" placeholder="Enter Username" id="uname" name="name" required>

		      <label for="email"><b style="font-family: Helvetica Neue; color: #acacac;">Email : </b></label>
		      <input type="mail" placeholder="Enter Email" name="email" required>

		      <label for="psw"><b style="font-family: Helvetica Neue; color: #acacac;">Password : </b></label>
		      <input type="password" placeholder="Enter Password" name="psw" required>

		      <label for="psw2"><b style="font-family: Helvetica Neue; color: #acacac;">Confirm Password : </b></label>
		      <input type="password" placeholder="Confirm Password" name="psw2" required>

		      <label>
		        <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px; color: #acacac;"> <b style="font-family: Helvetica Neue; color: #acacac;">Remember me</b>
		      </label>

		      <p style="font-family: Helvetica Neue; color: #acacac;">By creating an account you agree to our <a href="#myReg" style="color:dodgerblue">Terms & Privacy</a>.</p>

		      <div class="clearfix">
		        <button type="button" id="cancel" onclick="document.getElementById('myReg').style.display='none'" class="button3" style="margin-right: 5%; 
				    background-color: #333;
				    padding: 6px 16px;
				    font-size: 14px;">Cancel</button>
		        <button type="button" class="button2" style=" padding:6px 16px; font-size: 14px;" name="reg" id="next">Next </button>
		      </div>
		    </div>
		  </form>
	  </div>
	</div>
</body>