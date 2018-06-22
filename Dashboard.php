<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<?php
		session_start();
		include('connection.php');
		if (!empty($_SESSION['uname'])) {
			$uname = $_SESSION['uname'];
			$myQuery = "SELECT * FROM registration WHERE username='".$uname."'";
			$r=  mysqli_query($dbc, $myQuery);// or die($myQuery."<br/><br/>".mysql_error());
			$row = mysqli_fetch_array($r, MYSQLI_BOTH);
			if (empty($row)) {
				echo "<script> alert('Session Expired!!'); window.location = 'logout.php'; </script>";
			}
			$_SESSION['uname'] = $uname;
		}
		else {
			echo "<script>
					alert('Log in to use dashboard!');
					window.location.href = 'Tagboard.php?val=Tags';
			</script>";	      	exit();
		}
	    if(empty($_COOKIE['session'])) {
		    echo "<script> alert('Session Expired!!'); window.location = 'logout.php'; </script>";
		}
	?>
	<link rel="stylesheet" type="text/css" href="dashboard.css">
	<link rel="stylesheet" type="text/javascript" href="postvalidation.js">
	<title>1Tag</title>
	<style type="text/css">
		.element, .outer-container {
		 	width: 750px;
			height: 1000px;
			margin-left: auto;
			margin-right: auto;
		}
		 
		.outer-container {
			border: 5px transparent;
			position: relative;
			overflow: hidden;
			border-radius: 8px;
			background-color: rgba(0,0,0,0.4);
		}
		 
		.inner-container {
		 position: absolute;
		 left: 0;
		 overflow-x: hidden;
		 overflow-y: scroll;
		}
		 
		.inner-container::-webkit-scrollbar {
		 display: none;
		}
		.image-upload {
			border-radius: 2px;
			height: 38px;
			margin-left: 65px;
			margin-top: -10px;
			width: 40px;
		}
		.image-upload > input {
		    display: none;
		}
		.gh {
			width: 85%;
			color: #333;
		}
		input#tagbox {
			position: absolute;
			margin-top: -22px;
			margin-left: -170px;
			padding: 2px;
			border-color: transparent;
			border-radius: 5px;
			background-color: transparent;
			border-color: #222;
		}
		input#tagbox:focus {
			border-color: #333;
		    background-color: transparent;
		    color: #eaeaea;
		    outline: none;
		}
		#uploadPreview {
			position: absolute;
			margin-left: 20px;
			margin-top: -21px;
		}
		h4{
		    position: relative;
		    margin-top: 40px;
		    margin-bottom: 40px;
		    margin-left: auto;
		    margin-right: auto;
		    text-align: center;
		    color: #aaa;
		    font-family: Lucida Sans Unicode;
		    font-size: 20px;
		}

		h4:hover{
		    color: #EAEAEA;
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
		.results {
			background-color: #333;
			padding-bottom: 3px;
			padding-top: 20px;
			padding-left: 3px;
		}
	</style>
</head>
<body id="bd" style="background-image: url('jjj.jpg'); object-fit: cover;">
	<nav id="myHeader" style="margin-left: -9px; margin-right: -9px; margin-top: -8px; position: fixed; top: 8px; width: 100%; min-width: 600px;">
	    <ul class="ls">
	    	<?php
				if (!empty($row['avatar'])) {
					echo "<li class='lsa'><img src='images/".$row['avatar']."' class='avatar' width='32px' onmouseover='focImg(this)' onmouseout='unfocImg(this)' style='margin-left: 15px; margin-top: 5px;cursor:pointer; border-width:2px; border-color: #4CAF50; border-style: solid; border-radius:50%; height:32px !important;'></li>";
				}
			?>
	        <li class="lsa"><a href="profile.php">Profile</a></li>
	        <li class="lsa"><a href="Dashboard.php">Dashboard</a></li>
	        <li class="lsa"><a href="Tagboard.php?val=Tags">Tagboard</a></li>
	        <li class="lsa"><a href="" id="sr">Search</a></li>
	        <li class="lsa"><div id="div1" style="display: none; margin-top: 13px; margin-left: 5px; margin-right: 5px;">
	        	<form action="search.php" method="POST">
				<input type="search" autocomplete="off" size="25" onkeyup="showResult(this.value)" name="input">
				<button type="submit">Go</button>
				</form>
			</div></li>
	        <i class="fa fa-bell" id="new" style="float:right;margin-right:2%;margin-top: 12px;font-size:22px; color:#4caf50;cursor:pointer;"><label id="number" style="display:none;background-color: #ef4e26;font-size: 14px;float:right;margin-top: 12px;color:black;font-family: sans-serif;padding: 2px 2px;border-radius: 2px;"></label></i>
			<button type="button" id="logout" class="button3"  onclick="window.location.href = 'logout.php'" 
															   value="check" style="															        
															   	   margin-right: 2%;
				        										   padding: 6px 16px;
				        										   font-size: 14px;
				        										   margin-top: 10px;">Log out</button>
	    </ul>
	</nav>

	<div class="results" id="livesearch" style="display:none;position:fixed;z-index:1;max-height: 300px;width: 207px;font-family: sans-serif;overflow: auto;margin-left:520px;margin-top: 2.5%;">no suggestions</div>
	<div class="notifs" style="display: none;"> </div>

	<div class="dash" >
		<h1 style="font-family: Lucida Sans Typewriter;">Dashboard</h1>
	</div>
	<div class="shadow"></div>

	<div class="container">
		<p><br></p>
		<br>
		<div class="postbox">
			<p><br></p>
			<p><br></p>
			<form action="make_post.php" enctype="multipart/form-data" method="post">
				<textarea class="post" maxlength="180" id="posst" name="post" cols="90" rows="4" placeholder="Write a post..."></textarea><hr class="gh">
			    <button type="submit" class="button4" name="posted">POST</button>
			    <div class="image-upload">
				    <label for="file-input">
				    	<img src="cam0.png" width="130%" onmouseover="this.src='cam1.png';" onmouseout="this.src='cam0.png';"/>
				    </label>
				    <input id="file-input" name="image" accept="image/*" onchange="previewImg();" type="file"/>
				</div>
				<input type="text" id="tagbox" name="tag" pattern="#[A-Za-z0-9_]{2,50}" placeholder="e.g.:#hash_tag" onfocusin="focusFunction()" onfocusout="blurFunction()" title="Character limit: 2-50" required>
				<img src="http://upload.wikimedia.org/wikipedia/commons/c/ce/Transparent.gif" id="uploadPreview" style="width: 40px; height: 40px;" />
				<p id="pp" style="float: right; margin-right: 16px; margin-top: -20px; font-size: 17px; color: #eaeaea;"></p>
			</form>
		</div>
			<p><br></p>
			<style>a:visited{color:#eaeaea;}</style>
		<p style="text-align: center; margin-top: -10px;color: #eaeaea;margin-left:auto; margin-right:auto;font-family: sans-serif; font-size: 20px;"><a href="#" style="text-decoration: none;color: #2bd877;" id="rec">Most Recent</a> | | <a href="#" style="text-decoration: none;color:#eaeaea;" id="pop">Most popular</a> | | <a href="#" style="text-decoration: none;color:#eaeaea;" id="dis">Most Discussed</a></p><br>
		<div class="outer-container">
			<div class="inner-container">
				<div class="element">
					 <div id="poss"><?php include('posta.php'); ?></div>
					<br><br><br>
				</div>
			</div>
		</div>	
	</div>
	
	<footer style="margin-top:1500px!important;">Copyright &copy; 1tag.com</footer>
	<?php
    $qq = mysqli_query($dbc, "SELECT * FROM `notifications` WHERE receiver='$uname' AND sender!='$uname' AND flag='unseen' OR flag='req' OR flag='admin' OR flag='flag'");
 	$rww = mysqli_fetch_array($qq, MYSQLI_BOTH);
    $r0 = mysqli_num_rows($qq);
    if ($r0==0) :
    ?>
    <script>
   		$("#new").removeClass( "fa-bell");
	    $("#new").addClass( "fa-bell-o");
	    $("#new").css({"color":"#eaeaea"});
	</script>
	<?php else :
	?>
	<script>
	    $("#number").show();
	    $("#number").html(+<?php echo $r0; ?>);
	</script>
	<?php endif ?>
	<script type="text/javascript">
		var search = document.getElementById('sr');
		var click_count = 1;

		search.onclick = function(event) {
			event.preventDefault();
			click_count++;
			if (click_count%2==0) {
				document.getElementById('div1').style.display = "block";
				document.getElementById('livesearch').style.display = "block";
			} else {
				document.getElementById('div1').style.display = "none";
				document.getElementById('livesearch').style.display = "none";
			}
		}

		var popular = document.getElementById('pop');
		var recent = document.getElementById('rec');
		var discussed = document.getElementById('dis');

		popular.onclick = function(event) {
			event.preventDefault();
			this.style.color='#2bd877';
			recent.style.color='#eaeaea';
			discussed.style.color='#eaeaea';
			$.ajax({
				url:"popularpost.php",
				method:"POST",
				data:{
						users: 'user'
					},
				success:function(data)
				{
				 $('#poss').html(data);
				}
			});
		}
		discussed.onclick = function(event) {
			event.preventDefault();
			this.style.color='#2bd877';
			recent.style.color='#eaeaea';
			popular.style.color='#eaeaea';
			$.ajax({
				url:"discuss.php",
				method:"POST",
				data:{
						users: 'user'
					},
				success:function(data)
				{
				 $('#poss').html(data);
				}
			});
		}
		recent.onclick = function(event) {
			event.preventDefault();
			this.style.color='#2bd877';
			popular.style.color='#eaeaea';
			discussed.style.color='#eaeaea';
			$.ajax({
				url:"postssss.php",
				method:"POST",
				data:{
						users: 'user'
					},
				success:function(data)
				{
				 $('#poss').html(data);
				}
			});
		}

		var	count=0;
		$("#new").click(function(event){
			event.preventDefault();

		    $(this).removeClass( "fa-bell");
		    $(this).addClass( "fa-bell-o");
		    $(this).css({"color":"#eaeaea"});
	    	$("#number").hide();
			if (count%2==0) {load_notifs();count++;}
			else{$('.notifs').hide();count++;}
		});


		function load_notifs()
		{	
			$.ajax({
				url:"fetch_notifs.php",
				method:"POST",
				data:{
						users: 1
					},
				success:function(data)
				{
				 $('.notifs').show();
				 $('.notifs').html(data);
				}
			});
		}
	</script>

	<script type="text/javascript">
		var textarea = document.querySelector("textarea");
		var tg = document.getElementsByName("tag")[0];


	    function previewImg() {
	        var oFReader = new FileReader();
	        oFReader.readAsDataURL(document.getElementById("file-input").files[0]);

	        oFReader.onload = function (oFREvent) {
	            document.getElementById("uploadPreview").src = oFREvent.target.result;
	            document.getElementById("uploadPreview").style.border = "2px solid #333";
	            document.getElementById("uploadPreview").style.borderRadius = "4px";
	        };
	    };

		function focusFunction(){tg.placeholder=' ';}
		function blurFunction(){tg.placeholder='e.g.:#hash_tag';}

		textarea.addEventListener("input", function(){
		    var maxlength = this.getAttribute("maxlength");
		    var currentLength = this.value.length;

		    if( currentLength >= maxlength ){
		        document.getElementById('pp').innerText = maxlength - currentLength + "/" + maxlength;
		    }else{
		        document.getElementById('pp').innerText = maxlength - currentLength + "/" + maxlength; 
		    }
		});
		textarea.onpaste = function(e){
		    //do some IE browser checking for e
		    var max = this.getAttribute("maxlength");
		    e.clipboardData.getData('text/plain').slice(0, max);
		};
		function showResult(str) {
		  if (str.length==0) { 
		    document.getElementById("livesearch").innerHTML="";
		    document.getElementById("livesearch").style.border="0px";
		    return;
		  }
		  if (window.XMLHttpRequest) {
		    // code for IE7+, Firefox, Chrome, Opera, Safari
		    xmlhttp=new XMLHttpRequest();
		  } else {  // code for IE6, IE5
		    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		  xmlhttp.onreadystatechange=function() {
		    if (this.readyState==4 && this.status==200) {
		      document.getElementById("livesearch").innerHTML=this.responseText;
		      document.getElementById("livesearch").style.border="1px solid #A5ACB2";
		    }
		  }
		  xmlhttp.open("GET","livesearch.php?q="+str,true);
		  xmlhttp.send();
		}
	</script>

</body>
</html>