<!DOCTYPE html>
<html>
<head>
	<title>1Tag</title>
	<meta name="viewport" content="width=device-width, height=device-height, user-scalable=yes, initial-scale=1">
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<link rel="stylesheet" type="text/css" href="theme.css">
</head>
<body>
<div id="myModal" class="modal">
	  <!-- Modal content -->
	  <div class="modal-content" style="background-image: url('3.jpg');">
	    <span onclick="document.getElementById('close').style.display='none'" class="close" title="Close Modal" style="margin-right: 2%">&times;</span>
		  <form class="modal-content" style="background-color: transparent;" action="login.php" method="post">
		    <div style="background-color: transparent; margin-left: 50px; margin-top: -10px; margin-right: 0; margin-bottom: 0; width: 400px;">
		      <h3 style="color: #acacac; font-size: 30px; font-family: Helvetica Neue;">Sign In</h3>
		      <p style="font-family: Helvetica Neue; color: #acacac;">Please fill in this form to create an account.</p>
		      <hr>
		      <label for="Username"><b style="font-family: Helvetica Neue; color: #acacac;">Username : </b></label>
		      <input type="text" placeholder="Enter Username" name="uname" value="<?php if(isset($_COOKIE["uname"])) { echo $_COOKIE["uname"]; } ?>" required>

		      <label for="email"><b style="font-family: Helvetica Neue; color: #acacac;">Email : </b></label>
		      <input type="text" placeholder="Enter Email" autocomplete="email"  name="email" value="<?php if(isset($_COOKIE["email"])) { echo $_COOKIE["email"]; } ?>" required>

		      <label for="psw"><b style="font-family: Helvetica Neue; color: #acacac;">Password : </b></label>
		      <input type="password" placeholder="Enter Password" autocomplete="on"  name="psw" value="<?php if(isset($_COOKIE["psw"])) { echo $_COOKIE["psw"]; } ?>" required>

		      <label>
		        <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px; color: #acacac;"> <b style="font-family: Helvetica Neue; color: #acacac;">Remember me</b>
		      </label>

		      <p class="message">Are you not registered?<a href="" style="color:dodgerblue">Register</a>.</p>

		      <div class="clearfix">
		        <button type="button" id="cancel" onclick="document.getElementById('myModal').style.display='none'" class="button3" style="margin-right: 5%; 
				    background-color: #333;
				    padding: 6px 16px;
				    font-size: 14px;">Cancel</button>
		        <button type="submit" class="button2" style=" padding:6px 16px; font-size: 14px;" name="login" value="submit">Sign In</button>
		      </div>
		    </div>
		  </form>
	  </div>
	</div>

	<div id="myReg" class="modal">
	  	<!-- Modal content -->
	  <div class="modal-content" style="background-image: url('3.jpg'); overflow-y: initial !important; padding-bottom: 25px !important;">
	    <span onclick="document.getElementById('close').style.display='none'" class="close" title="Close Modal" style="margin-right: 2%">&times;</span>
		  <form class="modal-content" style="background-color: transparent;"  onsubmit="return formValidation();" action="registration.php" enctype="multipart/form-data" method="post">
		    <div style="background-color: transparent; margin-left: 50px; margin-top: -10px; margin-right: 0; margin-bottom: 0; width: 400px;">
		      <h3 style="color: #acacac; font-size: 30px; font-family: Helvetica Neue;">Sign Up</h3>
		      <p style="font-family: Helvetica Neue; color: #acacac;margin-top: -10px;">Please fill in this form to get registrated.</p>
		      <hr>
		      <div style="height: 280px; overflow-y: auto;">
			      <label for="Username"><b style="font-family: Helvetica Neue; color: #acacac;">Username<font color="Tomato">*</font> : </b></label>
			      <p id="un"></p>
			      <input type="text" placeholder="Enter Username" id="uname" name="uname" required>

			      <label for="email"><b style="font-family: Helvetica Neue; color: #acacac;">Email<font color="Tomato">*</font> : </b></label>
			      <p id="em"></p>
			      <input type="text" placeholder="Enter Email" id="email" autocomplete="email"  name="email" required>

			      <label for="psw"><b style="font-family: Helvetica Neue; color: #acacac;">Password<font color="Tomato">*</font> : </b></label>
			      <p id="p1"></p>
			      	<input type="password" id="psw0" placeholder="Enter Password"  autocomplete="on" name="psw" onkeyup='check();' required>

			      <label for="psw2"><b style="font-family: Helvetica Neue; color: #acacac;">Confirm Password<font color="Tomato">*</font> : </b></label>
			      <span id='message'></span>
			      <p></p>
			      <input type="password" id="pswcon" placeholder="Confirm Password" autocomplete="on"  name="psw2" onkeyup='check();' required>

			      <label for="dtb"><b style="font-family: Helvetica Neue; color: #acacac;">Age : </b></label>
			      <p id="age"> </p>
				    <input type="text" id="ageid" placeholder="Enter Your Age" name="age">
			  
			      <label for="gender"><b style="font-family: Helvetica Neue; color: #acacac;">Gender(Male/Female) : </b></label>
			      <p style="color: #eaeaea; font-size: 18px;"><input type="radio" checked="checked" name="gender" value="M">Male   <input type="radio" name="gender" value="F">Female</p>
			      <label for="avatar"><b style="font-family: Helvetica Neue; color: #acacac;">Select your Avatar : </b></label>
			      <input type="file" name="avatar" id="avatar" accept="image/*" style="margin-top: 12px; margin-bottom: 18px; color: #eaeaea;">
			</div>
		      <label>
		        <input type="checkbox" checked="checked" name="remember" style="margin-bottom:0px; color: #acacac;margin-top: 10px;"> <b style="font-family: Helvetica Neue; color: #acacac;">Remember me</b>
		      </label>

		      <p style="font-family: Helvetica Neue; color: #acacac;">By creating an account you agree to our <a href="" style="color:dodgerblue">Terms & Privacy</a>.</p>

		      <div class="clearfix">
		        <button type="button" id="cancel2" onclick="document.getElementById('myReg').style.display='none'" class="button3" style="margin-right: 5%; 
				    background-color: #333;
				    padding: 6px 16px;
				    font-size: 14px;">Cancel</button>
		        <button type="submit" class="button2" style="padding:6px 16px; font-size: 14px;" name="reg" id="register"">Register </button>
		      </div>
		    </div>
		  </form>
	  </div>
	</div>
</body>
</html>