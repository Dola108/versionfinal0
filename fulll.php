<head>
	<title>Full Post</title>
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
		.dropbtn {
		    color: black;
		    font-size: 16px;
		    border: none;
		    cursor: pointer;
		    text-decoration: none;
		}

		.dropdown {
		    position: relative;
		    display: inline-block;
		}

		.dropdown-content {
		    display: none;
		    position: absolute;
		    background-color: #333;
		    min-width: 160px;
		    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
		    z-index: 1000;
		}

		.dropdown-content a {
		    color: white;
		    font-family: sans-serif;
		    font-size:12px;
		    padding: 6px 6px;
		    text-decoration: none;
		    display: block;
		}

		.dropdown-content a:hover { background-color: #4CAF50;}
		.notifs {
		    position: fixed;
		    margin-left: 1030px;
		    display: inline-block;
		    background-color: #333;
		    z-index: 1;
		    min-width: 300px;
		    max-width: 300px;
		    min-height: 350px!important;
		    max-height: 350px;
		    margin-top: 0!important;
		    overflow: auto;
		    overflow-wrap: break-word;
		}

		.notifss {
		    color: white!important;
		    font-family: sans-serif;
		    font-size:16px;
		    padding-top: 18px!important;
		    padding-bottom: 14px!important;
		    text-decoration: none!important;
		    display: block;
		}

		.notifss2 {
		    color: white!important;
		    font-family: sans-serif;
		    font-size:16px;
		    padding-top: 18px!important;
		    padding-bottom: 14px!important;
		    text-decoration: none!important;
		    display: block;
		}

		.notifss:hover { background-color: #4CAF50;}
		.notifss2:hover { background-color: #4CAF50;}

	</style>
</head>
<body style="background-image: url('jjj.jpg');">
	<nav id="myHeader" style="margin:0; position: relative;float:top;width: 100%; min-width: 600px;">
	    <ul class="ls">
	        <li class="ls"><a href="profile.php">Profile</a></li>
	        <li class="ls"><a href="Tagboard.php?val=Tags">Tags</a></li>
	        <li class="ls"><a href="Dashboard.php">Dashboard</a></li>
	        <li class="ls"><a href="" id="sr">Search</a></li>
	        <li class="ls"><div id="div1" style="display: none; margin-top: 13px; margin-left: 5px; margin-right: 5px;"><form action="search.php" method="post"><input type="search" name="search" value="#" placeholder="Search Tags" pattern="#[A-Za-z0-9_]{2,50}"/><button type="submit">go</button></form></div></li>
	        <i class="fa fa-bell" id="new" style="float:right;margin-right:2%;margin-top: 12px;font-size:22px; color:#4caf50;cursor:pointer;"><label id="number" style="display:none;background-color: #ef4e26;font-size: 14px;float:right;margin-top: 12px;color:black;font-family: sans-serif;padding: 2px 2px;border-radius: 2px;"></label></i>
			<button type="button" id="logout" class="button3"  onclick="window.location.href = 'logout.php'" 
															   value="check" style="															        
															   	   margin-right: 2%;
				        										   padding: 6px 16px;
				        										   font-size: 14px;
				        										   margin-top: 10px;">Log out</button>
	    </ul>
	</nav>
	<div class="notifs" style="display: none;"> </div>
<?php 
	session_start();
	include('connection.php');
    if (empty($_SESSION['uname'])) {
    	echo "<script>
					alert('Log in to use dashboard!');window.close();
			</script>";
      	exit();
    }
	
	if (!empty($_SESSION['uname'])) {
		$uname = $_SESSION['uname'];
		$_SESSION['uname'] = $uname;
	}
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
	} else {
		//$id=310;
		print_r($_GET['id']);
	}

	$myQuery = "SELECT * FROM post WHERE id='".$id."'";
	$ro=  mysqli_query($dbc, $myQuery);//or die($myQuery."<br/><br/>".mysql_error());
	
	$rw = mysqli_fetch_array($ro, MYSQLI_BOTH);
	$user = $rw['username'];
    $n=$rw['id'];
	$tag = $rw['tag'];
	$image = $rw['image'];
	$posts = nl2br($rw['post']);
	$taglink = preg_replace( "/#([^\s]+)/", "<a href=\"Tagboard.php?val=%23$1\"  style='text-decoration:none; font-size: 14px; color: #eaeaea; font-family: sans-serif;'>".$tag."</a>", $tag );
	$post = preg_replace( '#((https?|ftp)://(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#i', "<a href='$1' target='_blank' style='font-size: 18px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word; padding-bottom:20px;'>$1</a>", $posts );
	$url = preg_replace( '/.*(?=https{0,1}:\/\/[\w\-\.\/#?&=]*)/', "<a href='$1' target='_blank' style='text-decoration:none; font-size: 14px; color: #eaeaea; font-family: sans-serif;'>$1</a>", $posts );
	$link = preg_replace( '/.*(?=https{0,1}:\/\/[\w\-\.\/#?&=]*)/', '$1', $posts );
	if(preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $link)) {
		$frame = str_replace('/watch?v=', '/embed/', $link);
		echo "<script> $('#fram').show(); </script>";
	}
	echo "
	<div style='margin-left:5%;margin-top:3%;width:90%;background-color: #111;padding:30px 30px;border-radius:10px;'>
	<p><a href=\"profile.php?un=".$user."\" style='text-decoration:none; font-size: 22px; color: #4CAF50; font-family: sans-serif;'>".$user."</a></p>
	<p style='margin-top:-10px; font-size: 12px; color: #eaeaea; font-family: sans-serif;'>".$rw['time']."</p>
	<p style='word-wrap: break-word; font-size: 14px; color: #ACE3C4; font-family: sans-serif;'>post no.#".$rw['id']."</p>
	<p id='post-".$rw['id']."' style='font-size: 18px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word; padding-bottom:20px;'>".$post."</p>
	<p>".$taglink."</p><img src='images/".$rw['image']."' width='500px' style='display:none;margin-left:0px;margin-bottom:20px;'><iframe src=".$frame." width=\"420\" height=\"315\" id=\"fram\" style='display:none;'></iframe>
    <p><a href=\"#\" id='deltpost-".$rw['id']."' onclick=\"delpost(".$rw['id'].", event)\" style=\"text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif;\">delete</a><span id='hid-".$rw['id']."' style=\"display:none; color:#eaeaea; font-size:13px; margin-left:10px;\"> Are you sure?<a href=\"#\" class=\"yes\" id='y-".$rw['id']."' style=\"color:#eaeaea; font-size:13px;\"> Y</a> /<a href=\"#\" class=\"no\" id='no-".$rw['id']."' style=\"color:#eaeaea; font-size:13px;\"> N</a>
    <div class=\"dropdown\">
	  <a href=\"#\" onclick='setFlag(".$rw['id'].", event)' class=\"dropbtn\" id='flag-".$rw['id']."' style=\"text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif;margin-right:10px;\">flagpost </a>
	  <div class=\"dropdown-content\"><span onclick=\"$('.dropdown-content').hide()\" style=\"color:white;font-size:18px;float:right;margin-right:5px;cursor:pointer;\">&times;</span>
	    <a href=\"#\" id='fl1-".$rw['id']."'>Irrelevant Tag</a>
	    <a href=\"#\" id='fl2-".$rw['id']."'>Offensive</a>
	    <a href=\"#\" id='fl3-".$rw['id']."'>Violates Terms & Conditions</a>
	  </div>
	</div>
	</span>
	<i class=\"fa fa-thumbs-up plike\" id=\"plike-".$rw['id']."\" data-id=\"".$rw['id']."\" style=\"font-size:17px; margin-right:10px;\"></i> 
    <span id=\"displaylikes-".$rw['id']."\" style=\"color:#eaeaea\">".$rw['likes']."</span>
    <i class=\"fa fa-thumbs-down pdislike\" id=\"pdislike-".$rw['id']."\" data-id=\"".$rw['id']."\" style=\"font-size:17px; margin-right:10px;\"></i> </p>
	<div class=\"commentbox\" style='margin-left:-6.5%;'>
		<form class='cform' id=".$id." action=\"#\" enctype=\"multipart/form-data\" method=\"post\">
		    <div class=\"form-group\">
			<textarea class=\"post\" id=\"texts\" maxlength=\"180\" name=\"texts\" cols=\"90\" rows=\"3\" style=\"height:70px;\" placeholder=\"post a comment..\"></textarea>
			</div>
			<div class=\"form-group\">
				<input type=\"hidden\" name=\"comment_id\" id=\"comment_id\" value=".$id." />
				<input type=\"hidden\" name=\"post_id\" id=\"post_id\" value=".$id." />
				<input type=\"hidden\" name=\"posted_by\" id=\"posted_by\" value=".$user." />
				<input type=\"submit\" name=\"submit\" id=\"submit\" class=\"button4\" style=\"margin-left:5px;padding:6px 14px;\" value=\"post\" />
				<input type=\"button\" id=\"cross\" class=\"button4\" style=\"display:none;position:absolute;margin-left:29%; padding:6px 14px;\" value=\"cancel\" />
			<span id=\"pp\" style=\"margin-left: 70%;font-size: 17px; color: #eaeaea;\"></span>
			</div>
		</form>
	</div>
	<p><a style='text-decoration:none; font-size: 16px; color: #eaeaea; font-family: sans-serif;'>Comments</a></p>
	<hr class=\"gh\" style=\"margin-left:0px; margin-top:3px;width:96%;\">
	<div id=\"display_comment\" style='background-color:transparent;'></div>
	</div>";
	if(preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $link)) {
		echo "<script> $('#fram').show(); </script>";
	}
    
	if ($rw['username']!=$_SESSION['uname']) {
	  echo "<script>
	       $('#deltpost-".$rw['id']."').hide();
	    </script>";
	}
	if(!empty($rw['image'])) {
		echo "<script> $('img').css({'display':'block'}); </script>";
	}
    $myr = "SELECT * FROM likes WHERE c_id='$n' AND username='".$_SESSION['uname']."'";
    $rq=  mysqli_query($dbc, $myr);
    $rqw = mysqli_fetch_array($rq, MYSQLI_BOTH);
    if($rqw['checked']=="liked") {
  	  echo "<script> $('#plike-'+".$n.").addClass('highlight'); 
  	  				 $('#pdislike-'+".$n.").prop('disabled', true);
  	  		</script>";
  	} else if($rqw['checked']=="disliked") {
  	  echo "<script> $('#pdislike-'+".$n.").addClass('highlight'); 
  	  				 $('#plike-'+".$n.").prop('disabled', true);
  	  		</script>";
  	}
    $myr2 = "SELECT * FROM flags WHERE c_id='$n' AND username='".$_SESSION['uname']."'";
    $rq2=  mysqli_query($dbc, $myr2);
    $rqw2 = mysqli_fetch_array($rq2, MYSQLI_BOTH);
    if(!empty($rqw2)) {
  	  echo "<script> $('.dropdown').html('<a style=\"font-size:12px;color:red;\">[flagged]</a>'); </script>";
  	}
?>
<br>
<br>
<p style="background-color:#333;color:#eaeaea;font-family: sans-serif;font-size: 22px;float: bottom;text-align: center;padding-top: 10px;padding-bottom: 10px;margin-bottom: 0;">@1Tag.com</p>
</body>
<?php
    $qq = mysqli_query($dbc, "SELECT * FROM `notifications` WHERE receiver='$uname' AND flag='unseen' OR flag='req' OR flag='admin' OR flag='flag'");
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
<script>
function delpost(x, e) {
    e.preventDefault();
    $("#hid-"+x).show();
    $("#y-"+x).click(function(event) {
    	event.preventDefault();
    	$.ajax ({
    		type:'post',
    		url:'editpost.php',
    		data:{
    		    delete: x
    		},
    		success:function(response) {
    		    if(response=="success") {
    		        alert("Post Deleted!");
    		        window.location.href='Dashboard.php';
    		    }
    		}
    	});
    });
    $("#no-"+x).click(function(event) {
    	event.preventDefault();
    	$("#hid-"+x).hide();
    });
}
function setFlag(x, e) {
	e.preventDefault();
	$(".dropdown-content").show();
	$("#fl1-"+x).click(function(event) {
		event.preventDefault();
		var title = $(this).html();
		$.ajax ({
			type:'post',
			url:'editpost.php',
			data:{
			    flag: x,
			    title: title
			},
			success:function(response) {
			    alert("Post Flagged!");
			    $(".dropdown-content").hide();
			    $(".dropdown").html("<a style='font-size:12px;color:red;'>[flagged]</a>");
			}
		});
	});
	$("#fl2-"+x).click(function(event) {
		event.preventDefault();
		var title = $(this).html();
		$.ajax ({
			type:'post',
			url:'editpost.php',
			data:{
			    flag: x,
			    title: title
			},
			success:function(response) {
			    alert("Post Flagged!");
			    $(".dropdown-content").hide();
			    $(".dropdown").html("<a style='font-size:12px;color:red;'>[flagged]</a>");
			}
		});
	});
	$("#fl3-"+x).click(function(event) {
		event.preventDefault();
		var title = $(this).html();
		$.ajax ({
			type:'post',
			url:'editpost.php',
			data:{
			    flag: x,
			    title: title
			},
			success:function(response) {
			    alert("Post Flagged!");
			    $(".dropdown-content").hide();
			    $(".dropdown").html("<a style='font-size:12px;color:red;'>[flagged]</a>");
			}
		});
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
$(document).ready(function(){
	var id=<?php echo $id; ?>;
	var pid=id;
	$('.cform').on('submit', function(event){
		event.preventDefault();
		id = $("#comment_id").val();
		var fdata = $(this).serialize();
		$.ajax({
			url:"add_comment.php",
			method:"POST",
			data: fdata,
   			dataType:"JSON",
			success:function(response)
			{
				if(response)
				{
					$('.cform')[0].reset();
					$('#comment_id').val(pid);
					$('#cross').hide();
					load_comment();
				}
			}
		});
	});

	load_comment();

	function load_comment()
	{	
		$.ajax({
			url:"fetch_comment2.php",
			method:"POST",
			data:{
					id: pid
				},
			success:function(data)
			{
			 $('#display_comment').html(data);
			}
		});
	}

	$(document).on('click', '.reply', function(event){
		event.preventDefault();
		var comment_id = $(this).attr("id");
		$('#cross').show();
		$('#comment_id').val(comment_id);
	 	$('#texts').attr("placeholder", "Reply to #"+comment_id);
	 	$('#texts').focus();
	 	$('#cross').click(function(){
	 		$('#texts').attr("placeholder", "post a comment..");
	 		$('#cross').hide();
			$('#comment_id').val(pid);
		});
	});
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
});
</script>
<script type="text/javascript">
	var search = document.getElementById('sr');
	var click_count = 1;

	search.onclick = function(event) {
		event.preventDefault();
		click_count++;
		if (click_count%2==0) {
			document.getElementById('div1').style.display = "block";
		} else {
			document.getElementById('div1').style.display = "none";
		}
	}

	var textarea = document.querySelector("textarea");

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
</script>