<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<?php
		include('connection.php');
		$id = $_GET["id"];
		if (!empty($_SESSION['uname'])) {
			$uname = $_SESSION['uname'];
			$_SESSION['uname'] = $uname;
		}
	?>
	<script type="application/javascript">
	  function resizediv2(obj) {
	    obj.style.height = obj.contentWindow.document.body.scrollHeight*1.1 + 'px';
	  }
	</script>
	<link rel="stylesheet" type="text/css" href="dashboard.css">
<link rel="stylesheet" type="text/css" href="view.css">
	<style type="text/css">
		p a:hover {
			color: #4CFF5F !important;
		}
		p.del a:hover {
			color: red !important;
		}
		.buttonq,.cancel,.replyb,.replyc{
		    background-color: #444;
		    border: none;
		    border-radius: 3px;
		    color: white;
		    padding: 6px 10px;
		    text-align: center;
		    text-decoration: none;
		    font-size: 12px;
		    cursor: pointer;
		    margin-right: 5px;
		    -webkit-transition-duration: 0.4s;
		    transition-duration: 0.4s;
		}
		.buttonq:hover,.cancel:hover,.replyb:hover,.replyc:hover{
		    box-shadow: 0 12px 16px 0 rgba(89, 149, 149, 0.6),0 17px 50px 0 rgba(89, 149, 149, 0);
		    background-color: #4CAF50;
		}
		.replies{
			display:none;
		}
	</style>
	<title>1Tag</title>
</head>
<body style="background-color: black;">
		<?php
			if (empty($id)) {
				echo "<h2 style='text-align: center;'>No posts to show.</h2>";
			}
			else {
				$myQuery = "SELECT * FROM comments WHERE post_id='".$id."' ORDER BY time DESC";
				$ro=  mysqli_query($dbc, $myQuery) or die($myQuery."<br/><br/>".mysql_error());
				$num_row = mysqli_num_rows($ro);

				while($num_row!=0) {
					$rw = mysqli_fetch_array($ro, MYSQLI_BOTH);
					$cid = $rw['id'];
					$tag = $rw['tag'];
					$image = $rw['image'];
					$posts = nl2br($rw['texts']);
					$user = $rw['username'];
					$taglink = preg_replace( "/#([^\s]+)/", "<a target=\"_blank\" href=\"Tagboard.php?val=%23$1\"  style='text-decoration:none; font-size: 14px; color: #eaeaea; font-family: sans-serif;'>".$tag."</a>", $tag );
					$myr = "SELECT * FROM replies WHERE c_id='".$cid."'";
					$rq=  mysqli_query($dbc, $myr);
					$num_reps = mysqli_num_rows($rq);
					echo "
					<article class='art' id=".$cid.">
							<p><a href=\"profile.php?un=".$user."\" target=\"_blank\" style='text-decoration:none; font-size: 22px; color: #4CAF50; font-family: sans-serif;'>".$user."</a></p>
							<p style='margin-top:-10px; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>".$rw['time']." post no.#".$rw['id']."</p>
							<p class=\"comment\" id=".$cid." style='font-size: 16px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word;padding-bottom:20px;width:70%;'>".$posts."  ".$taglink."</p>
						<div>
							<p><a href='#'>reply</a><i class=\"fa fa-thumbs-up\" data-id=".$cid." id=\"like\" style=\"font-size:17px; margin-right:10px;\"></i> <i onclick=\"myFunction2(".$cid.")\" class=\"fa fa-thumbs-down\" style=\"font-size:17px; margin-right:10px;\"></i></p>
							<hr>
						</div>
					</article>";
					
					$num_row--;
					$_SESSION['id'] = $rw['id'];
				}
			}
		?>
<script>
var count=1;
var count2=1;
$("#like").filter(function(){return this.data-id==x}).click(function() {
	alert(this.id);
	if(count2%2==0) {
    	return;
    }
    count++;
    if(count%2==0) {
      $(this).css("color", "#1bb86f");
    } else {
      $(this).css("color", "#eaeaea");
    }
});
function myFunction(x) {
	if(count2%2==0) {
    	return;
    }
    count++;
    if(count%2==0) {
    //alert(count);
      x.style.color = "#1bb86f";
    } else {
      x.style.color = "#eaeaea";
    }
}
function myFunction2(x) {
	if(count%2==0) {
    	return;
    }
    count2++;
    if(count2%2==0) {
      x.style.color = "#1bb86f";
    } else {
      x.style.color = "#eaeaea";
    }
}
</script>
</body>
</html>