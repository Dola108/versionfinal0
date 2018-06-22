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
    <th style="max-width: 15px;width: 15px;">Id</th>
    <th style="max-width: 25px;width: 25px;">Tag</th>
    <th style="max-width: 60px;width: 60px;">Post</th>
    <th style="max-width: 25px;width: 25px;">Posted By</th>
    <th style="max-width: 20px;width: 20px;">Time</th>
    <th style="max-width: 20px;width: 20px;">Delete</th>
  </tr>
</table>
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
while($num_row!=0) {
  $rw = mysqli_fetch_array($row, MYSQLI_BOTH);
  $n=$rw['id'];
  $post = preg_replace( '/(https{0,1}:\/\/[\w\-\.\/#?&=]*)/', "<a href='$1' target='_blank' style='font-size: 18px; color: #ACE3C4; font-family: sans-serif; overflow-wrap: break-word; padding-bottom:20px;'>$1</a>", $rw['post'] );
  $output .= '
  <table class="users" style="word-wrap: break-word;">
    <tr>
      <td style="max-width: 15px;width: 15px;">'.$rw['id'].'</td>
      <td style="max-width: 25px;width: 25px;">'.$rw['tag'].'</td>
      <td style="max-width: 60px;width: 60px;">'.$post.'</td>
      <td style="max-width: 25px;width: 25px;">'.$rw['username'].'</td>
      <td style="max-width: 20px;width: 20px;">'.$rw['time'].'</td>
      <td style="max-width: 20px;width: 20px;"><a href="#" id="act-'.$rw['id'].'" onclick="delpost('.$rw['id'].', event)">Delete</a></td>
    </tr>
  </table>
 ';
  $num_row--;
}

echo $output;
$out .='<div id="disp"></div>';
echo $out;

?>
<script>
  function delpost(x, e) {
    e.preventDefault();
    if (confirm('Delete Post Permanently?')==true) {
      e.preventDefault();
      $.ajax ({
        type:'post',
        url:'editpost.php',
        data:{
            delete: x
        },
        success:function(response) {
            if(response=="success") {
                alert("Post Deleted!");
                $("#act-"+x).html("<a style='font-size:12px;color:red;'>[Deleted]</a>");
            }
        }
      });
    } else {
      e.preventDefault();
    }
}
</script>