<link rel="stylesheet" type="text/css" href="view.css">
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style type="text/css">
i {
  margin: 4px;
  font-size: 16px;
  cursor: pointer;
}
.highlight {
  color: #1bb86f;
}
</style>
<?php

session_start();
include('connection.php');

if(!empty($_POST["id"]))
{
  $pid = $_POST["id"];
} else {
  echo "p";
}
$pd=0;
$query = "SELECT * FROM comment WHERE c_id='".$pid."' ORDER BY time DESC";
$row=  mysqli_query($dbc, $query) or die($query."<br/><br/>".mysql_error());
$num_row = mysqli_num_rows($row);

$output = '';
while($num_row!=0) {
  $rw = mysqli_fetch_array($row, MYSQLI_BOTH);
  $n=$rw['id'];
  $texts = nl2br($rw['texts']);
  $post = preg_replace( '/(https{0,1}:\/\/[\w\-\.\/#?&=]*)/', "<a href='$1' target='_blank' style='text-decoration:none; font-size: 14px; color: #eaeaea; font-family: sans-serif;'>$1</a>", $texts );
  $myr = "SELECT * FROM likes WHERE c_id='$n' AND username='".$_SESSION['uname']."'";
  $rq=  mysqli_query($dbc, $myr);
  $rqw = mysqli_fetch_array($rq, MYSQLI_BOTH);
  if($rqw['checked']=="liked") {
    echo "<script>  $('#like-'+".$n.").addClass('highlight'); 
               $('#dislike-'+".$n.").prop('disabled', true);
          </script>";
  } else if($rqw['checked']=="disliked") {
    echo "<script> $('#dislike-'+".$n.").addClass('highlight'); 
               $('#like-'+".$n.").prop('disabled', true);
          </script>";
  }
  if ($rw['username']!=$_SESSION['uname']) {
    echo "<script>
         $('#delt-".$rw['id']."').hide();
      </script>";
  }
  $output .= '
  <article class="art" id='.$rw['id'].'>
    <div>
      <p><a href="profile.php?un='.$rw["username"].'" target="_blank" style="text-decoration:none; font-size: 22px; color: #4CAF50; font-family: sans-serif; margin-top:5px;">'.$rw["username"].'</a></p>
      <p style="margin-top:-10px; font-size: 12px; color: #eaeaea; font-family: sans-serif;">'.$rw["time"].' post no.#'.$rw['id'].'</p>
      <p class="comment" id='.$rw['id'].' style="font-size: 16px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word;padding-bottom:10px;width:70%;">'.$post.'</p>
      <div class="hiddens" id='.$rw['id'].' style="display:none;"><p></p><button class="buttonq" id='.$rw['id'].'>save</button><button class="cancel" id='.$rw['id'].' >cancel</button></div>
      <p><a href="#" onclick="divClicked('.$rw['id'].', event)" id="edit" style="text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif; margin-right:10px;">edit</a> <a href="#" class="reply" id="'.$rw["id"].'" style="text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif; margin-right:10px;">reply</a>
        <i class="fa fa-thumbs-up like" id="like-'.$rw['id'].'" data-id="'.$rw['id'].'" style="font-size:17px; margin-right:10px;"></i> 
        <span id="displaylikes-'.$rw['id'].'" style="color:#eaeaea">'.$rw['likes'].'</span>
        <i class="fa fa-thumbs-down dislike" id="dislike-'.$rw['id'].'" data-id="'.$rw['id'].'" style="font-size:17px; margin-right:10px;"></i> 
        <a href="#" class="delt" id="delt-'.$rw["id"].'" onclick="delcmnt('.$rw["id"].', event)" style="text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif;">delete</a><span class="hidden2" id='.$rw["id"].' style="display:none; color:#eaeaea; font-size:13px; margin-left:10px;"> Are you sure?<a href="#" class="del" id="del-'.$rw["id"].'" style="color:#eaeaea; font-size:13px;"> Y</a> /<a href="#" class="canceld" id='.$rw["id"].' style="color:#eaeaea; font-size:13px;"> N</a></span></p>
    </div>
  </article>
 ';
$output .= get_reply_comment($dbc, $rw["id"], 0);
  $num_row--;
}

echo $output;

function get_reply_comment($dbc, $pd, $marginleft)
{
$output = '';
$query = "SELECT * FROM comment WHERE c_id = '".$pd."'";
$row=  mysqli_query($dbc, $query) or die($query."<br/><br/>".mysql_error());
$num_row = mysqli_num_rows($row);
 if($pd == 0)
 {
  $marginleft = 0;
 }
 else
 {
  $marginleft = $marginleft + 48;
 }
  while($num_row!=0) {
    $rw = mysqli_fetch_array($row, MYSQLI_BOTH);
    $n=$rw['id'];
    $texts = nl2br($rw['texts']);
  $post = preg_replace( '/(https{0,1}:\/\/[\w\-\.\/#?&=]*)/', "<a href='$1' target='_blank' style='text-decoration:none; font-size: 14px; color: #eaeaea; font-family: sans-serif;'>$1</a>", $texts );
    $myr = "SELECT * FROM likes WHERE c_id='$n' AND username='".$_SESSION['uname']."'";
    $rq=  mysqli_query($dbc, $myr);
    $rqw = mysqli_fetch_array($rq, MYSQLI_BOTH);
    if($rqw['checked']=="liked") {
      echo "<script>  $('#like-'+".$n.").addClass('highlight'); 
               $('#dislike-'+".$n.").prop('disabled', true);
          </script>";
    } else if($rqw['checked']=="disliked") {
      echo "<script> $('#dislike-'+".$n.").addClass('highlight'); 
               $('#like-'+".$n.").prop('disabled', true);
          </script>";
    }
    if ($rw['username']!=$_SESSION['uname']) {
      echo "<script>
           $('#delt-".$rw['id']."').hide();
        </script>";
    }
     $output .= '
     <article class="art" id='.$rw['id'].' style="margin-left:'.$marginleft.'px">
      <div>
        <p><a href="profile.php?un='.$rw["username"].'" target="_blank" style="text-decoration:none; font-size: 22px; color: #4CAF50; font-family: sans-serif;">'.$rw["username"].'</a></p>
        <p style="margin-top:-10px; font-size: 12px; color: #eaeaea; font-family: sans-serif;">'.$rw["time"].' post no.#'.$rw['id'].'</p>
        <p class="comment" id='.$rw['id'].' style="font-size: 16px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word;padding-bottom:10px;width:70%;">'.$post.'</p>
        <div class="hiddens" id='.$rw['id'].' style="display:none;"><p></p><button class="buttonq" id='.$rw['id'].'>save</button><button class="cancel" id='.$rw['id'].' >cancel</button></div>
        <p><a href="#" onclick="divClicked('.$rw['id'].', event)" id="edit" style="text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif; margin-right:10px;">edit</a> <a href="#" class="reply" id="'.$rw["id"].'" style="text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif; margin-right:10px;">reply</a> 
        <i class="fa fa-thumbs-up like" id="like-'.$rw['id'].'" data-id="'.$rw['id'].'" style="font-size:17px; margin-right:10px;"></i> 
        <span id="displaylikes-'.$rw['id'].'" style="color:#eaeaea">'.$rw['likes'].'</span>
        <i class="fa fa-thumbs-down dislike" id="dislike-'.$rw['id'].'" data-id="'.$rw['id'].'" style="font-size:17px; margin-right:10px;"></i> 
        <a href="#" class="delt" id="delt-'.$rw["id"].'" onclick="delcmnt('.$rw["id"].', event)" style="text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif;">delete</a><span class="hidden2" id='.$rw["id"].' style="display:none; color:#eaeaea; font-size:13px; margin-left:10px;"> Are you sure?<a href="#" class="del" id="del-'.$rw["id"].'" style="color:#eaeaea; font-size:13px;"> Y</a> /<a href="#" class="canceld" id='.$rw["id"].' style="color:#eaeaea; font-size:13px;"> N</a></span></p>
      </div>
    </article>
     ';
     $output .= get_reply_comment($dbc, $rw["id"], $marginleft);
    $num_row--;
  }
 return $output;
}

?>
<script type="text/javascript">
  var texts;
  var cid;
    var oFReader = new FileReader();
    var file;
    var data;
    var nor;
  function divClicked(x, e) {
    e.preventDefault();
    cid=x;
      var divHtml = $(".comment").filter(function(){return this.id==x}).html();
      var editableText = $("<textarea class='post' style='height:60px;'/>");
      $(".hiddens").filter(function(){return this.id==x}).show();
      editableText.val(divHtml);
      $(".comment").filter(function(){return this.id==x}).replaceWith(editableText);
      editableText.focus();
      // setup the blur event for this new textarea
    $(".buttonq").filter(function(){return this.id==x}).click(function() {
          var texts = $(editableText).val();
      $.ajax ({
        type:'post',
        url:'editcomment.php',
        data:{
          edited: texts,
          id: x
        },
        success:function(response) {
          if(response=="success") {
              var viewableText = $("<p class='comment' id="+x+" style='font-size: 16px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word;padding-bottom:20px;'>");
              viewableText.html(texts);
              editableText.replaceWith(viewableText);
            $(".hiddens").filter(function(){return this.id==x}).hide();
          }
        }
      });
    });
    $(".cancel").click(function(event) {
      event.preventDefault();
      var viewableText = $("<p class='comment' id="+x+" style='font-size: 16px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word;padding-bottom:20px;'>");
      viewableText.html(divHtml);
        editableText.replaceWith(viewableText);
      $(".hiddens").filter(function(){return this.id==x}).hide();
    });
  }
  function delcmnt(x, e) {
    e.preventDefault();
    $(".hidden2").filter(function(){return this.id==x}).show();
    $("#del-"+x).click(function(event) {
      event.preventDefault();
      $.ajax ({
        type:'post',
        url:'editcomment.php',
        data:{
          delete: x
        },
        success:function(response) {
          if(response=="success") {
              alert("Comment Deleted!");
              $("#delt-"+x).replaceWith("<label style='font-size:12px;color:red;'>deleted</label>");
              $(".hidden2").filter(function(){return this.id==x}).hide();
          }
        }
      });
    });
    $(".canceld").click(function(event) {
      event.preventDefault();
      $(".hidden2").filter(function(){return this.id==x}).hide();
    });
  }
  
    $( ".like").click(function(event) {
      event.preventDefault();
      x = $(this).attr("data-id");
      if($( "#like-"+x).prop('disabled')){return;}

      $(this).toggleClass( "highlight");
      if($(this).hasClass( "highlight" )) {
        $.ajax ({
          type:'post',
          url:'editcomment.php',
          data:{
            liked: x
          },
          success:function(data) {
            if(data) {
                $( "#displaylikes-"+x).html(data);
            }
          }
        });
        $("#dislike-"+x).prop('disabled', true);
      } else {
        $.ajax ({
          type:'post',
          url:'editcomment.php',
          data:{
            unliked: x
          },
          success:function(data) {
            if(data) {
                $( "#displaylikes-"+x).html(data);
            }
          }
        });
        $("#dislike-"+x).prop('disabled', false);
      }
    });
    $( ".dislike" ).click(function(event) {
      event.preventDefault();
      x = $(this).attr("data-id");
      if($( "#dislike-"+x ).prop('disabled')) {return;}

      $(this).toggleClass( "highlight");
      if($(this).hasClass( "highlight" )) {
        $.ajax ({
          type:'post',
          url:'editcomment.php',
          data:{
            disliked: x
          },
          success:function(data) {
            if(data) {
                $( "#displaylikes-"+x).html(data);
            }
          }
        });
        $("#like-"+x).prop('disabled', true);
      } else {
        $.ajax ({
          type:'post',
          url:'editcomment.php',
          data:{
            undliked: x
          },
          success:function(data) {
            if(data) {
                $( "#displaylikes-"+x).html(data);
            }
          }
        });
        $("#like-"+x).prop('disabled', false);
      }
    });
</script>