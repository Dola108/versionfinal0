<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style type="text/css">
  
.notifs {
    position: absolute;
    position: fixed;
    margin-left: 1030px;
    display: inline-block;
    background-color: #333;
    z-index: 1;
    min-width: 300px;
    max-width: 300px;
    min-height: 350px;
    max-height: 350px;
    margin-top: 38px;
    overflow: auto;
    overflow-wrap: break-word;
    padding-bottom: 10px;
    border-bottom: 8px solid #444;
    border-left: 8px solid #444;
}

.notifss {
    color: white!important;
    font-family: sans-serif;
    font-size:16px;
    padding: 8px 8px;
    text-decoration: none;
    display: block;
}
.notifss2 {
    color: white!important;
    font-family: sans-serif;
    font-size:16px;
    padding: 8px 8px;
    text-decoration: none;
    display: block;
}


.notifss:hover { background-color: #4CAF50;}
.notifss2:hover { background-color: #4CAF50;}

</style>

    <span style="color: #eaeaea;margin-bottom: 0;cursor: pointer;margin-left: 10px;" class="check">Mark all as read</span><hr class="newhr" style="margin-bottom: 0!important;">
<?php
session_start();
include('connection.php');
$uname = $_SESSION['uname'];
//GROUP BY c_id, title HAVING
if(!empty($_POST["users"]))
{
  $val = $_POST["users"];
} 

$query = "SELECT * FROM `notifications` WHERE receiver='$uname' AND sender!='$uname' ORDER BY id DESC";
$row=  mysqli_query($dbc, $query) or die($query."<br/><br/>".mysql_error());
$num_row = mysqli_num_rows($row);

$output = '';
while($num_row!=0) {
  $rw = mysqli_fetch_array($row, MYSQLI_BOTH);
  $n=$rw['id'];
  if ($rw['flag']=="unseen") {
    $output .= '
    <a href="#" class="notifss" id='.$rw['id'].' data-id='.$rw['c_id'].' style="background-color:#4caf50;">
      <p> New '.$rw['title'].' on post no.#'.$rw['c_id'].' </p>
    </a>
    <hr class="newhr" style="margin-top:0px;margin-bottom:0px;">
   ';
  } else if($rw['flag']=="admin" && strpos($rw['sender'], 'Admin') !== false) {
    $output .= '
    <a href="#" class="notifss2" id='.$rw['id'].' data-id='.$rw['c_id'].' style="background-color:#4caf50;">
      <p>post no.#'.$rw['c_id'].' was '.$rw['title'].' by admin  </p>
    </a><hr class="newhr" style="margin-top:0px;margin-bottom:0px;">
   ';
  } else if($rw['flag']=="flag" && strpos($rw['sender'], 'Admin') !== false) {
    $output .= '
    <a href="#" class="notifss2" id='.$rw['id'].' data-id='.$rw['c_id'].' style="background-color:#4caf50;">
      <p>Flag on post no.#'.$rw['c_id'].' was '.$rw['title'].' by admin  </p>
    </a><hr class="newhr" style="margin-top:0px;margin-bottom:0px;">
   ';
  } else if($rw['flag']=="req" && strpos($rw['sender'], 'Admin') !== false) {
    $output .= '
    <a href="#" class="notifss2" id='.$rw['id'].' data-id='.$rw['c_id'].' style="background-color:#4caf50;">
      <p>Account deletion request no.#'.$rw['c_id'].' was '.$rw['title'].'</p>
    </a><hr class="newhr" style="margin-top:0px;margin-bottom:0px;">
   ';
  } else if(strpos($rw['sender'], 'Admin') !== false) {
    $output .= '
    <a href="#" class="notifss2" id='.$rw['id'].' data-id='.$rw['c_id'].'>
      <p>id no.#'.$rw['c_id'].' was '.$rw['title'].' by admin  </p>
    </a><hr class="newhr" style="margin-top:0px;margin-bottom:0px;">
   ';
  } else {
    $output .= '
    <a href="#" class="notifss" id='.$rw['id'].' data-id='.$rw['c_id'].'>
      <p> New '.$rw['title'].' on post no.#'.$rw['c_id'].' </p>
    </a><hr class="newhr" style="margin-top:0px;margin-bottom:0px;">
   ';
  }
  
  $num_row--;
}

echo $output;

?>
<script>
  $( ".notifss").click(function(event) {
      event.preventDefault();
      x = $(this).attr("id");
      pid = $(this).attr("data-id");

      $.ajax({
        url:"editpost.php",
        method:"POST",
        data:{
            notif: x,
            pid: pid
          },
        success:function(response)
        {
          if (response=="success") {
            $(location).attr('href', 'fullpost.php?id='+pid);
          }
        }
      });
      
  });
  $( ".notifss2").click(function(event) {
      event.preventDefault();
      x = $(this).attr("id");
      pid = $(this).attr("data-id");

      $.ajax({
        url:"editpost.php",
        method:"POST",
        data:{
            notif: x,
            pid: pid
          },
        success:function(response)
        {
          if (response=="success") {
            alert("You cannot violate our terms & conditions or the board rules. Read our terms & conditions again.");
          }
        }
      });
      
  });
</script>
<script type="text/javascript">
  $(".check").click(function () {
    $.ajax({
        url:"editpost.php",
        method:"POST",
        data:{
            check: 1,
          },
        success:function(response)
        {
          if (response=="success") {
            $(".notifss2").css({"background-color": "transparent"});
            $(".notifss").css({"background-color": "transparent"});
          }
        }
      });
  });
</script>