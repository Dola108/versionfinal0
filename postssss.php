<head>
  <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="view.css">
  <title>1Tag</title>
  <style type="text/css">
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
    i {
      margin: 4px;
      font-size: 16px;
      cursor: pointer;
    }
    .highlight {
      color: #1bb86f;
    }
  </style>
</head>
<?php
session_start();
include('connection.php');

if(!empty($_POST["users"]))
{
  $val = $_POST["users"];
} else if (!isset($_POST['pid'])){
  echo "no users";
}

if (isset($_POST['pid'])) {
  $pid = $_POST['pid'];
  $query = "SELECT * FROM `post` WHERE id='$pid'";
} else {
  $query = "SELECT * FROM `post` ORDER BY time DESC";
}

$row=  mysqli_query($dbc, $query) or die($query."<br/><br/>".mysql_error());
$num_row = mysqli_num_rows($row);

$output = '';
$out = '';
$myQuery = "SELECT * FROM post ORDER BY time DESC";
$ro=  mysqli_query($dbc, $myQuery);//or die($myQuery."<br/><br/>".mysql_error());
$num_row = mysqli_num_rows($ro);

while($num_row!=0) {
$rw = mysqli_fetch_array($ro, MYSQLI_BOTH);
$id = $rw['id'];
$user = $rw['username'];
$tag = $rw['tag'];
$image = $rw['image'];
$posts = nl2br($rw['post']);
$taglink = preg_replace( "/#([^\s]+)/", "<a href=\"Tagboard.php?val=%23$1\"  style='text-decoration:none; font-size: 14px; color: #eaeaea; font-family: sans-serif;'>".$tag."</a>", $tag );
$post = preg_replace( '#((https?|ftp)://(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#i', "<a href='$1' target='_blank' style='text-decoration:none; font-size: 14px; color: #eaeaea; font-family: sans-serif;'>$1</a>", $posts );
$url = preg_replace( '#((https?|ftp)://(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#i', "<a href='$1' target='_blank' style='text-decoration:none; font-size: 14px; color: #eaeaea; font-family: sans-serif;'>$1</a>", $posts );

$c = "SELECT * FROM comment WHERE c_id='".$id."'";
$rc=  mysqli_query($dbc, $c) or die($c."<br/><br/>".mysql_error());
$nc = mysqli_num_rows($rc);
if (empty($image)) {
    $output.= '
    <article>
      <div class="div boxed">
        <p><a href="profile.php?un='.$user.'" style="text-decoration:none; font-size: 22px; color: #4CAF50; font-family: sans-serif;">'.$user.'</a></p>
        <p style="font-size: 12px; color: #eaeaea; font-family: sans-serif;">'.$rw['time'].'</p>
          <p style="word-wrap: break-word; font-size: 14px; color: #ACE3C4; font-family: sans-serif;">post no.#'.$rw['id'].'</p>
          <p style="font-size: 18px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word; padding-bottom:20px;">'.$post.'</p>
          <p>'.$taglink.'</p>
        <p><a href="fullpost.php?id='.$id.'" target="_blank" id="v" style="text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif; margin-right:5px;">View full post</a>  <a href="fullpost.php?id='.$id.'" target="_blank" style="text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif;">add comments  ('.$nc.')</a></p>
        <p><i class="fa fa-thumbs-up plike" id="plike-'.$rw['id'].'" data-id="'.$rw['id'].'" style="font-size:17px; margin-right:10px;"></i> 
          <span id="displaylikes-'.$rw['id'].'" style="font-size: 14px; color: #eaeaea; font-family: sans-serif;margin-right:5px;">'.$rw['likes'].'</span>
        <i class="fa fa-thumbs-down pdislike" id="pdislike-'.$rw['id'].'" data-id="'.$rw['id'].'" style="font-size:17px; margin-right:10px;"></i></p>
      </div>
    </article>';          
      $myr = "SELECT * FROM likes WHERE c_id='$id' AND username='".$_SESSION['uname']."'";
      $rq=  mysqli_query($dbc, $myr);
      $rqw = mysqli_fetch_array($rq, MYSQLI_BOTH);
      if($rqw['checked']=="liked") {
        echo "<script> $('#plike-'+".$id.").addClass('highlight'); 
                       $('#pdislike-'+".$id.").prop('disabled', true);
              </script>";
      } else if($rqw['checked']=="disliked") {
        echo "<script> $('#pdislike-'+".$id.").addClass('highlight'); 
                       $('#plike-'+".$id.").prop('disabled', true);
              </script>";
      }
  } else {
    $output.= '
    <article>
      <div class="div boxed">
        <p><a href="profile.php?un='.$user.'" style="text-decoration:none; font-size: 22px; color: #4CAF50; font-family: sans-serif;">'.$user.'</a></p>
        <p style="font-size: 12px; color: #eaeaea; font-family: sans-serif;">'.$rw['time'].'</p>
          <p style="word-wrap: break-word; font-size: 14px; color: #ACE3C4; font-family: sans-serif;">post no.#'.$rw['id'].'</p>
          <p style="font-size: 18px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word; padding-bottom:20px;">'.$post.'</p>
          <p>'.$taglink.'</p>
          <img src="images/'.$rw['image'].'" width="90%;" style="margin-left:-10px;">
        <p><a href="fullpost.php?id='.$id.'" target="_blank" id="v" style="text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif; margin-right:5px;">View full post</a>  <a href="fullpost.php?id='.$id.'" target="_blank" style="text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif;">add comments  ('.$nc.')</a></p>
        <p><i class="fa fa-thumbs-up plike" id="plike-'.$rw['id'].'" data-id="'.$rw['id'].'" style="font-size:17px; margin-right:10px;"></i> 
          <span id="displaylikes-'.$rw['id'].'" style="font-size: 14px; color: #eaeaea; font-family: sans-serif;margin-right:5px;">'.$rw['likes'].'</span>
        <i class="fa fa-thumbs-down pdislike" id="pdislike-'.$rw['id'].'" data-id="'.$rw['id'].'" style="font-size:17px; margin-right:10px;"></i></p>
      </div>
    </article>';  
      $myr = "SELECT * FROM likes WHERE c_id='$id' AND username='".$_SESSION['uname']."'";
      $rq=  mysqli_query($dbc, $myr);
      $rqw = mysqli_fetch_array($rq, MYSQLI_BOTH);
      if($rqw['checked']=="liked") {
        echo "<script> $('#plike-'+".$id.").addClass('highlight'); 
                       $('#pdislike-'+".$id.").prop('disabled', true);
              </script>";
      } else if($rqw['checked']=="disliked") {
        echo "<script> $('#pdislike-'+".$id.").addClass('highlight'); 
                       $('#plike-'+".$id.").prop('disabled', true);
              </script>";
      }
  }
  $num_row--;
}


  echo $output;
?>
<script>
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