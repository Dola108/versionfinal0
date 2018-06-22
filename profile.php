<?php  
	include('connection.php');
	session_start();

    /*if (empty($_SESSION['uname'])) {
    	$_SESSION['uname'] = null;
    	echo ("{$_GET['uname']}"."<br/>"."{$_SESSION['uname']}");
    }*/
    if (isset($_GET['un']) && $_GET['un']!=$_SESSION['uname']) {
    	$uname = $_SESSION['uname'];
    	header('Location: otherusers.php?un='.$_GET['un']);
    }
    if (strpos($_SESSION['uname'], 'Admin') !== false) {
    	$uname = $_SESSION['uname'];
    	header('Location: admin_page.php?un='.$_GET['un']);
    }
    if(empty($_COOKIE['session'])) {
	    echo "<script> alert('Session Expired!!'); window.location = 'logout.php'; </script>";
	}
	
    else if (empty($_SESSION['uname'])) {
    	header('Location: homepage.php');
      	
      	exit();
    } else {
    	$uname = $_SESSION['uname'];

		
		$myQuery = "SELECT * FROM registration WHERE username='".$uname."'";
		$r=  mysqli_query($dbc, $myQuery);// or die($myQuery."<br/><br/>".mysqli_error($dbc));
		if (!$r) {
			echo "Error: failure. ERROR: ".mysqli_error($dbc);
			echo "Debugging errno: ".mysqli_errno($dbc).PHP_EOL;
			echo "Debugging error : ".mysqli_error($dbc).PHP_EOL;
			exit;
		}

		$row = mysqli_fetch_array($r, MYSQLI_BOTH);
		if (empty($row)) {
			echo "<script> alert('Session Expired!!'); window.location = 'logout.php'; </script>";
		}

		//echo $row['id'].PHP_EOL;
	//	echo $row['username'].PHP_EOL;
		//echo $row['avatar'].PHP_EOL;
		
		$_SESSION['uname'] = $uname;
		
		$mQuery = "SELECT * FROM post WHERE username='".$uname."'";
		$r2=  mysqli_query($dbc, $mQuery);//or die($myQuery."<br/><br/>".mysql_error());
		$row2 = mysqli_fetch_array($r2, MYSQLI_BOTH);
		$id = $row2['id'];
		$_SESSION['id'] = $id;
    }
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="theme.css">
	<link rel="stylesheet" type="text/css" href="dashboard.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>1Tag</title>
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<style type="text/css">
		.element, .outer-container {
		 	width: 750px;
			height: 750px;
			margin-left: auto;
			margin-right: auto;
		}
		 
		.outer-container {
			margin-top: 120px;
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
		.newhr {
		    width: 100%;
		    height: 0px;    
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
<body style="min-width: 100%;background-color: #414141;">
	<nav id="myHeader">
	    <ul class="ls">
	        <li class="lsa"><a href="profile.php">Profile</a></li>
	        <li class="lsa"><a href = "Dashboard.php" style="font-size: 15px !important;">Dashboard</a></li>
	        <li class="lsa"><a href = "Tagboard.php?val=Tags" style="font-size: 15px !important;">Tagboard</a></li>
	        <li class="lsa"><a href="" id="sr" ondblclick="document.getElementById('div1').style.display='none'" style="font-size: 15px !important;">Search</a></li>
	        <li class="lsa"><div id="div1" style="display: none; margin-top: 13px; margin-left: 5px; margin-right: 5px;">
	        	<form action="search.php" method="POST">
				<input type="search" autocomplete="off" size="25" onkeyup="showResult(this.value)" name="input">
				<button type="submit">Go</button>
				</form>
			</div></li>
			<i class="fa fa-bell" id="new" style="float:right;margin-right:2%;margin-top: 12px;font-size:22px; color:#4caf50;cursor:pointer;"><label id="number" style="display:none;background-color: #ef4e26;font-size: 14px;float:right;margin-top: 12px;color:black;font-family: sans-serif;padding: 2px 2px;border-radius: 2px;"></label></i>
	        <button type="button" id="logout" class="button3"  onclick="window.location.href = 'logout.php?val=1'" value="check" style="margin-right: 2%;
		padding: 6px 16px;
		font-size: 14px;margin-top: 10px;">Log out</button>
	    </ul>
	
	</nav>
	<div class="results" id="livesearch" style="display: none;position:fixed;z-index:0;max-height: 300px;width: 207px;font-family: sans-serif;overflow: auto;margin-left:460px;margin-top: 3%;color: #eaeaea;">no suggestion</div>
	<div class="notifs" style="display: none;"></div>
	<div class="container-fluid">
		<div class="profile_container">
			<?php
				if (empty($row['avatar'])) {
					echo "<img src='blankavatar.png' class='avatar' onmouseover='focImg(this)' onmouseout='unfocImg(this)' >";
				}
				else {
					echo "<img src='images/".$row['avatar']."' class='avatar' onmouseover='focImg(this)' onmouseout='unfocImg(this)' >";
				}
			?>
			<?php
				echo "<h3 style=' width: 300px; word-wrap: break-word;'>". $uname."</h3>";
			?>
			<nav>
				<ul class="ls" style="background-color: rgba(0,0,0,0.4);">
			        <li class="ls" style="width: 100%; padding-bottom: 5px;"><a href="Dashboard.php">Write Post</a></li>
				</ul>
				<?php
					echo "<ul class=\"ls\" style=\"background-color: rgba(0,0,0,0.4);\">
						<li class=\"ls\" style=\"width: 100%; padding-bottom: 5px;\"><a href=\"info.php?un=".$uname."\">About</a></li>
					</ul>";
				?>
				<?php
					echo "<ul class=\"ls\" style=\"background-color: rgba(0,0,0,0.4);\">
						<li class=\"ls\" style=\"width: 100%; padding-bottom: 5px;\"><a href=\"Photos.php?un=".$uname."\">Photos</a></li>
					</ul>";
				?>
				<ul class="ls" style="background-color: rgba(0,0,0,0.4);">
			        <li class="ls" style="width: 100%; padding-bottom: 151%;"><a href="account.php">Account Settings</a></li>
				</ul>
			</nav>
		</div>
			
		<div class="post_container">
		<div class="outer-container">
			<div class="inner-container">
				<div class="element">
					<?php include('ownpost.php');?>
					<br><br><br><br><br>
				</div>
			</div>
		</div>	
		</div>
		<footer style="position: flex; margin-top: 68%; width: 98.9%;">1tag.com</footer>
	</div><?php
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
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
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

		function focImg(x) {
		    x.style.opacity = "0.9";
		}

		function unfocImg(x) {
		    x.style.opacity = "initial";
		}
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
	<script>
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
				 $('.notifs').css({"padding-top":"10px"});
				 $('.notifs').html(data);
				}
			});
		}
	</script>
</body>
</html>