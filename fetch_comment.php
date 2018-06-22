<link rel="stylesheet" type="text/css" href="view.css">
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php

//CHECK THE REASON BEHIND AUTO RELOAD FOR ALL EXCEPT THE LAST
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
  $output .= '
  <article class="art" id='.$rw['id'].'>
    <div>
      <p><a href="profile.php?un='.$rw["username"].'" target="_blank" style="text-decoration:none; font-size: 22px; color: #4CAF50; font-family: sans-serif; margin-top:5px;">'.$rw["username"].'</a></p>
      <p style="margin-top:-10px; font-size: 12px; color: #eaeaea; font-family: sans-serif;">'.$rw["time"].' post no.#'.$rw['id'].'</p>
      <p class="comment" id='.$rw['id'].' style="font-size: 16px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word;padding-bottom:10px;width:70%;">'.$rw["texts"].'</p>
      <div class="hiddens" id='.$rw['id'].' style="display:none;"><p></p><button class="buttonq" id='.$rw['id'].'>save</button><button class="cancel" id='.$rw['id'].' >cancel</button></div>
      <p><a href="#" onclick="divClicked('.$rw['id'].', event)" id="edit" style="text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif; margin-right:10px;">edit</a> <a href="#" class="reply" id="'.$rw["id"].'" style="text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif; margin-right:10px;">reply</a> <i onclick="myFunction(this)" class="fa fa-thumbs-up" style="font-size:17px; margin-right:10px;"></i> <i onclick="myFunction2(this)" class="fa fa-thumbs-down" style="font-size:17px; margin-right:10px;"></i> <a href="#" class="delt" id='.$rw["id"].' onclick="delcmnt('.$rw["id"].', event)" style="text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif;">delete</a><span class="hidden2" id='.$rw["id"].' style="display:none; color:#eaeaea; font-size:13px; margin-left:10px;"> Are you sure?<a href="#" class="del" id='.$rw["id"].' style="color:#eaeaea; font-size:13px;"> Y</a> /<a href="#" class="canceld" id='.$rw["id"].' style="color:#eaeaea; font-size:13px;"> N</a></span></p>
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
     $output .= '
     <article class="art" id='.$rw['id'].' style="margin-left:'.$marginleft.'px">
      <div>
        <p><a href="profile.php?un='.$rw["username"].'" target="_blank" style="text-decoration:none; font-size: 22px; color: #4CAF50; font-family: sans-serif;">'.$rw["username"].'</a></p>
        <p style="margin-top:-10px; font-size: 12px; color: #eaeaea; font-family: sans-serif;">'.$rw["time"].' post no.#'.$rw['id'].'</p>
        <p class="comment" id='.$rw['id'].' style="font-size: 16px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word;padding-bottom:10px;width:70%;">'.$rw["texts"].'</p>
        <div class="hiddens" id='.$rw['id'].' style="display:none;"><p></p><button class="buttonq" id='.$rw['id'].'>save</button><button class="cancel" id='.$rw['id'].' >cancel</button></div>
        <p><a href="#" onclick="divClicked('.$rw['id'].', event)" id="edit" style="text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif; margin-right:10px;">edit</a> <a href="#" class="reply" id="'.$rw["id"].'" style="text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif; margin-right:10px;">reply</a> <i onclick="myFunction(this)" class="fa fa-thumbs-up" style="font-size:17px; margin-right:10px;"></i> <i onclick="myFunction2(this)" class="fa fa-thumbs-down" style="font-size:17px; margin-right:10px;"></i> <a href="#" class="delt" id='.$rw["id"].' onclick="delcmnt('.$rw["id"].', event)" style="text-decoration:none; font-size: 12px; color: #eaeaea; font-family: sans-serif;">delete</a><span class="hidden2" id='.$rw["id"].' style="display:none; color:#eaeaea; font-size:13px; margin-left:10px;"> Are you sure?<a href="#" class="del" id='.$rw["id"].' style="color:#eaeaea; font-size:13px;"> Y</a> /<a href="#" class="canceld" id='.$rw["id"].' style="color:#eaeaea; font-size:13px;"> N</a></span></p>
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
    $(".del").filter(function(){return this.id==x}).click(function(event) {
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
              $(".delt").filter(function(){return this.id==x}).html("<a style='font-size:12px;color:red;'>deleted</a>");
          }
        }
      });
    });
    $(".canceld").click(function(event) {
      event.preventDefault();
      $(".hidden2").filter(function(){return this.id==x}).hide();
    });
  }
  function showReplies(x) {
      $(".replies").filter(function(){return this.id==x}).css("display", "inline-block");
      $(".hidereps").filter(function(){return this.id==x}).show();
  }
  function hideReplies(x) {
      $(".replies").filter(function(){return this.id==x}).hide();
      $(".hidereps").filter(function(){return this.id==x}).hide();
  }
</script>
<script>
var count=1;
var count2=1;
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