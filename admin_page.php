<head>
	<title>ADMIN PAGE</title>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
<link rel="stylesheet" type="text/css" href="view.css">
<link rel="stylesheet" type="text/css" href="dashboard.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script type="application/javascript">
	  function resizediv(obj) {
	    obj.style.height = obj.contentWindow.document.body.scrollHeight*1.2 + 'px';
	  }
	</script>
<style type="text/css">
	a{
		color: #eaeaea;
		font-family: sans-serif;
		font-size: 18px;
		text-decoration: none;
	}
	a:hover{
		color: white;
	}
	a:visited{
		color: #eaeaea;
	}
</style>
</head>
<body style="background-image: url('jjj.jpg');">
	<nav id="myHeader" style="margin:0; position: relative;float:top;width: 100%; min-width: 600px;">
	    <ul class="ls">
	        <li class="ls"><a href="profile.php">Profile</a></li>
	        <li class="ls"><a href="Tagboard.php?val=Tags">Tagboard</a></li>
	        <li class="ls"><a href="Dashboard.php">Dashboard</a></li>
			<button type="button" id="logout" class="button3"  onclick="window.location.href = 'logout.php'" 
															   value="check" style="															        
															   	   margin-right: 5%;
				        										   padding: 6px 16px;
				        										   font-size: 14px;
				        										   margin-top: 10px;">Log out</button>
	    </ul>
	</nav>
<?php 
	session_start();
	include('connection.php');
    if (empty($_SESSION['uname'])) {
    	header('Location: homepage.php');
      	exit();
    }
?>
<div style="display: inline-flex;width: 100%;">
	<div style='margin-left:4%;margin-top:3%;width:25%;background-color: #111;padding:30px 30px;border-radius:10px;'>
	  <a href="#" onclick="load_users()">Users</a><br><br>
	  <a href="#" onclick="load_posts()">Posts</a><br><br>
	  <a href="#" onclick="load_cmnts()">Comments</a><br><br>
	  <a href="#" onclick="load_flags()">Flags</a><br><br>
	  <a href="#" onclick="load_reqs()">Delete Requests</a><br><br>
	  <a href="#" onclick="load_mail()">Send Mail</a><br><br>
	</div>
	<div style='margin-left:4%;margin-top:3%;width:60%;background-color: #111;padding:30px 30px;border-radius:10px;'>
		<div id="display_users" style='background-color:transparent;'></div>
	</div>
</div>	

<br>
<br>
</body>

<script>
function load_users()
{	
	$.ajax({
		url:"fetch_users.php",
		method:"POST",
		data:{
				users: 'user'
			},
		success:function(data)
		{
		 $('#display_users').html(data);
		}
	});
}
function load_posts()
{	
	$.ajax({
		url:"fetch_posts.php",
		method:"POST",
		data:{
				users: 'user'
			},
		success:function(data)
		{
		 $('#display_users').html(data);
		}
	});
}
function load_cmnts()
{	
	$.ajax({
		url:"fetch_cmnts.php",
		method:"POST",
		data:{
				users: 'user'
			},
		success:function(data)
		{
		 $('#display_users').html(data);
		}
	});
}
function load_flags()
{	
	$.ajax({
		url:"fetch_flags.php",
		method:"POST",
		data:{
				users: 'user'
			},
		success:function(data)
		{
		 $('#display_users').html(data);
		}
	});
}
function load_reqs()
{	
	$.ajax({
		url:"fetch_reqs.php",
		method:"POST",
		data:{
				users: 'user'
			},
		success:function(data)
		{
		 $('#display_users').html(data);
		}
	});
}
function load_mail()
{	
	$.ajax({
		url:"fetch_mail.php",
		method:"POST",
		data:{
				users: 'user'
			},
		success:function(data)
		{
		 $('#display_users').html(data);
		}
	});
}
</script>