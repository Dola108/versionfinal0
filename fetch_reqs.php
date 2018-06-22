<style type="text/css">
.users {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

.users td{
    border: 1px solid #333;
    padding: 2px 2px;
    color: #eaeaea;
}
.users th {
    border: 1px solid #333;
    padding: 2px 2px;
    background-color: #eaeaea;
    color: black;
}
</style>
<table class="users">
  <tr>
    <th style="max-width: 15px;width: 15px;">User Id</th>
    <th style="max-width: 25px;width: 25px;">Requested By</th>
    <th style="max-width: 25px;width: 25px;">E-mail</th>
    <th style="max-width: 40px;width: 40px;">Title</th>
    <th style="max-width: 20px;width: 20px;">Time</th>
    <th style="max-width: 25px;width: 25px;">Remove Account</th>
    <th style="max-width: 25px;width: 25px;">Remove Flag</th>
  </tr>
</table>
<?php
session_start();
include('connection.php');

if(!empty($_POST["users"]))
{
  $val = $_POST["users"];
} else {
  echo "no users";
}

$query = "SELECT * FROM `reqs` ORDER BY time DESC";
$row=  mysqli_query($dbc, $query) or die($query."<br/><br/>".mysql_error());
$num_row = mysqli_num_rows($row);


$output = '';
$out = '';
while($num_row!=0) {
  $rw = mysqli_fetch_array($row, MYSQLI_BOTH);
  $n=$rw['parent_id'];
  $mail = $rw['email'];
  $body = "Dear user ".$rw['username'].", your account of 1tag.com was deleted as requested. Join us anytime when you would like to. Thanks for being with us.";
  $email = preg_replace( "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+/", "<a href=\"https://mail.google.com/mail/?view=cm&fs=1&to=".$mail."&su=Response to account deletion request&body=".$body."\">".$mail."</a>", $mail );

  $output .= '
  <table class="users">
    <tr style="overflow-wrap: break-word;">
      <td style="max-width: 15px;width: 15px;">'.$rw['parent_id'].'</td>
      <td style="max-width: 25px;width: 25px;">'.$rw['username'].'</td>
      <td style="max-width: 25px;width: 25px;">'.$email.'</td>
      <td style="max-width: 40px;width: 40px;">'.$rw['title'].'</td>
      <td style="max-width: 20px;width: 20px;">'.$rw['time'].'</td>
      <td style="max-width: 25px;width: 25px;"><a href="#" id="act-'.$rw['id'].'" onclick="deluser('.$rw['parent_id'].', event)">Delete</a></td>
      <td style="max-width: 25px;width: 25px;"><a href="#" id="act2-'.$rw['id'].'" onclick="delflag('.$rw['id'].', event)">Delete Flag</a></td>
    </tr>
  </table>
 ';
  $num_row--;
}

echo $output;

?>
<script>
function deluser(x, e) {
    e.preventDefault();
    if (confirm('Delete User Permanently?')==true) {
     if (confirm('Have you sent the E-mail?')==true) {
      e.preventDefault();
      $.ajax ({
        type:'post',
        url:'delete.php',
        data:{
            un: x
        },
        success:function(response) {
            if(response=="success") {
                alert("User Records Deleted!");
                $("#act-"+x).html("<a style='font-size:12px;color:red;'>[Deleted]</a>");
            }
        }
      });
     }
    } else {
      e.preventDefault();
    }
}
function delflag(x, e) {
    e.preventDefault();
    if (confirm('Delete Flag?')==true) {
      e.preventDefault();
      $.ajax ({
        type:'post',
        url:'editpost.php',
        data:{
            req: x
        },
        success:function(response) {
            if(response=="success") {
                alert("Uses Request Canceled!");
                $("#act2-"+x).html("<a style='font-size:12px;color:red;'>[Deleted]</a>");
            }
        }
      });
    } else {
      e.preventDefault();
    }
}
</script>