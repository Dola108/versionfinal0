<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<link rel="stylesheet" type="text/css" href="view.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<?php
		include('connection.php');
		//$val = $_GET["val"];
		if (isset($_GET['un'])) {
    	$uname = $_GET['un'];
    	$myQuery = "SELECT * FROM registration WHERE username='".$uname."'";
		$r=  mysqli_query($dbc, $myQuery);// or die($myQuery."<br/><br/>".mysqli_error($dbc));
		if (!$r) {
			echo "Error: failure. ERROR: ".mysqli_error($dbc);
			echo "Debugging errno: ".mysqli_errno($dbc).PHP_EOL;
			echo "Debugging error : ".mysqli_error($dbc).PHP_EOL;
			exit;
		}

		$row = mysqli_fetch_array($r, MYSQLI_BOTH);

		$mQuery = "SELECT * FROM post WHERE username='".$uname."'";
		$r2=  mysqli_query($dbc, $mQuery);
		$row2 = mysqli_fetch_array($r2, MYSQLI_BOTH);
		$id = $row2['id'];
		$_SESSION['id'] = $id;
    }

    else if (!empty($_SESSION['uname'])) {
			$uname = $_SESSION['uname'];
			$myQuery = "SELECT * FROM registration WHERE username='".$uname."'";
			$r=  mysqli_query($dbc, $myQuery) or die($myQuery."<br/><br/>".mysql_error());
			$row = mysqli_fetch_array($r, MYSQLI_BOTH);
			$_SESSION['uname'] = $uname;
		}
		else {
			echo "<script>
					alert('Log in to use dashboard!');
					window.location.href = 'Tagboard.php?val=Tags';
			</script>";
	      	// Immediately exit and send response to the client and do not go furthur in whatever script it is part of.
	      	exit();
		}
	?>
	<link rel="stylesheet" type="text/css" href="dashboard.css">
	<title>1Tag</title>
	<style type="text/css">
		i {
		  margin: 4px;
		  font-size: 16px;
		  cursor: pointer;
		}
		.highlight {
		  color: #1bb86f;
		}
		article {
			margin-top: 20px;
		    margin-left: 20px;
		    border-left: none;
		    padding: 2em;
		    overflow: hidden;
		}

		.boxed {
			width: 85%;
			border-radius: 15px;
		    background: rgba(0,0,0,0.7);
			margin: auto;
			padding: 7px 25px;
			margin-bottom: -26px;
			box-shadow: 5px 5px 10px #4CAF50;
		}
		.elements, .outer-containers {
			width: 550px;
			height: 80px;
			padding-left: 10px;
		}
		 
		.outer-containers {
			border: 0;
			position: relative;
			overflow: hidden;
			padding-bottom: 12px;
		}
		 
		.inner-containers {
			position: absolute;
			padding-right: 100%;
			left: 0;
			overflow-x: hidden;
			overflow-y: scroll;
		}
		 
		.inner-containers::-webkit-scrollbar {
			display: none;
		}
		p a:hover {
			color: #4CFF5F !important;
		}
		p.del a:hover {
			color: red !important;
		}

	</style>
</head>
<body>
		<?php
			if (empty($_SESSION['id'])) {
				echo "<h2 style='text-align: center;margin-top:5%;font-size:22px;'>No posts to show.</h2>";
			}
			else {
				$myQuery ="SELECT * FROM post WHERE username='".$uname."'ORDER BY time DESC";
				$ro=  mysqli_query($dbc, $myQuery);//or die($myQuery."<br/><br/>".mysql_error());
				$num_row = mysqli_num_rows($ro);

				while($num_row!=0) {
				$rw = mysqli_fetch_array($ro, MYSQLI_BOTH);
				$id = $rw['id'];
				$tag = $rw['tag'];
				$image = $rw['image'];
				$posts = nl2br($rw['post']);
				$taglink = preg_replace( "/#([^\s]+)/", "<a href=\"Tagboard.php?val=%23$1\"  style='text-decoration:none; font-size: 14px; color: #eaeaea; font-family: sans-serif;'>".$tag."</a>", $tag );
				
				$post = preg_replace( '/(https{0,1}:\/\/[\w\-\.\/#?&=]*)/', "<a href='$1' target='_blank' style='text-decoration:none; font-size: 14px; color: #eaeaea; font-family: sans-serif;'>$1</a>", $posts );
				echo "
				<article>
					<div class='div boxed'>
						<p><a href=\"profile.php?un=".$uname."\" style='text-decoration:none; font-size: 22px; color: #4CAF50; font-family: sans-serif;'>".$uname."</a></p>
						<p style='margin-top:-10px; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>".$rw['time']."</p>
							<p style='margin-bottom:-10px; word-wrap: break-word; font-size: 14px; color: #ACE3C4; font-family: sans-serif;'>post no.#".$rw['id']."</p>
							<p style='font-size: 18px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word; padding-bottom:20px;'>".$post."</p>
							<p>".$taglink."</p>
							<img id='img-".$rw['id']."' src='images/".$rw['image']."' width='90%;' style='display:none;margin-left:-10px;'>
						<p><a href=\"fullpost.php?id=".$id."\"target=\"_blank\" id='v' style='text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>View full post</a></p>
						<a href=\"#\" id='deltpost-".$rw['id']."' onclick=\"delpost(".$rw['id'].", event)\" style=\"text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif;\">delete</a><span id='hid-".$rw['id']."' style=\"display:none; color:#eaeaea; font-size:13px; margin-left:10px;\"> Are you sure?<a href=\"#\" class=\"yes\" id='y-".$rw['id']."' style=\"color:#eaeaea; font-size:13px;\"> Y</a> /<a href=\"#\" class=\"no\" id='no-".$rw['id']."' style=\"color:#eaeaea; font-size:13px;\"> N</a></span>
						<i class=\"fa fa-thumbs-up plike\" id=\"plike-".$rw['id']."\" data-id=\"".$rw['id']."\" style=\"font-size:17px; margin-right:10px;\"></i> 
					    <span id=\"displaylikes-".$rw['id']."\" style=\"color:#eaeaea\">".$rw['likes']."</span>
					    <i class=\"fa fa-thumbs-down pdislike\" id=\"pdislike-".$rw['id']."\" data-id=\"".$rw['id']."\" style=\"font-size:17px; margin-right:10px;\"></i> </p>
					</div>
				</article>";
				
				if ($rw['username']!=$_SESSION['uname']) {
				  echo "<script>
				       $('#deltpost-".$rw['id']."').hide();
				    </script>";
				}
				if (!empty($rw['image'])) {
				  echo "<script>
				       $('#img-".$rw['id']."').show();
				    </script>";
				}
			    $myr = "SELECT * FROM likes WHERE c_id='$id' AND username='".$_SESSION['uname']."'";
			    $rq=  mysqli_query($dbc, $myr);
			    $rqw = mysqli_fetch_array($rq, MYSQLI_BOTH);
			    if($rqw['checked']=="liked") {
			  	  echo "<script> $('#plike-'+".$id.").addClass('highlight'); </script>";
			  	} else if($rqw['checked']=="disliked") {
			  	  echo "<script> $('#pdislike-'+".$id.").addClass('highlight'); </script>";
			  	}
					
					$num_row--;
					$_SESSION['id'] = $rw['id'];
				}
			}
		?>
</body>
<script>
function delpost(x, e) {
    e.preventDefault();
    $("#hid-"+x).show();
    $("#y-"+x).click(function(event) {
    	event.preventDefault();
    	$.ajax ({
    		type:'post',
    		url:'delpost.php',
    		data:{
    		    id: x
    		},
    		success:function(response) {
    		    if(response=="success") {
    		        alert("Post Deleted!");
    		        $("#deltpost-"+x).html("<a style='font-size:12px;color:red;'>deleted</a>");
    				$("#hid-"+x).hide();
    		    }
    		}
    	});
    });
    $("#no-"+x).click(function(event) {
    	event.preventDefault();
    	$("#hid-"+x).hide();
    });
}
$( ".plike").click(function(event) {
   event.preventDefault();
   x = $(this).attr("data-id");
   if($( "#plike-"+x).prop('disabled')){return;}

   $(this).toggleClass( "highlight");
   if($(this).hasClass( "highlight" )) {
     $.ajax ({
       type:'post',
       url:'editpost.php',
       data:{
         liked: x
       },
       success:function(data) {
         if(data) {
            $( "#displaylikes-"+x).html(data);
         }
       }
     });
     $("#pdislike-"+x).prop('disabled', true);
   } else {
     $.ajax ({
       type:'post',
       url:'editpost.php',
       data:{
         unliked: x
       },
       success:function(data) {
         if(data) {
             $( "#displaylikes-"+x).html(data);
         }
       }
     });
     $("#pdislike-"+x).prop('disabled', false);
   }
 });
 $( ".pdislike" ).click(function(event) {
   event.preventDefault();
   x = $(this).attr("data-id");
   if($( "#pdislike-"+x ).prop('disabled')) {return;}

   $(this).toggleClass( "highlight");
   if($(this).hasClass( "highlight" )) {
     $.ajax ({
       type:'post',
       url:'editpost.php',
       data:{
         disliked: x
       },
       success:function(data) {
         if(data) {
             $( "#displaylikes-"+x).html(data);
         }
       }
     });
     $("#plike-"+x).prop('disabled', true);
   } else {
     $.ajax ({
       type:'post',
       url:'editpost.php',
       data:{
         undliked: x
       },
       success:function(data) {
         if(data) {
             $( "#displaylikes-"+x).html(data);
         }
       }
     });
     $("#plike-"+x).prop('disabled', false);
   }
 });
</script>