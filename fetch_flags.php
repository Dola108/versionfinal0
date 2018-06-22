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
    <th style="max-width: 15px;width: 15px;">Post Id</th>
    <th style="max-width: 25px;width: 25px;">Flagged By</th>
    <th style="max-width: 35px;width: 35px;">Flag</th>
    <th style="max-width: 20px;width: 20px;">Time</th>
    <th style="max-width: 25px;width: 25px;">Delete Flag</th>
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

$query = "SELECT * FROM `flags` ORDER BY time DESC";
$row=  mysqli_query($dbc, $query) or die($query."<br/><br/>".mysql_error());
$num_row = mysqli_num_rows($row);


$output = '';
$out = '';
while($num_row!=0) {
  $rw = mysqli_fetch_array($row, MYSQLI_BOTH);
  $n=$rw['id'];
  $output .= '
  <table class="users">
    <tr>
      <td style="max-width: 15px;width: 15px;"><a href="#" onclick="load('.$rw['c_id'].', event)">'.$rw['c_id'].'</a></td>
      <td style="max-width: 25px;width: 25px;">'.$rw['username'].'</td>
      <td style="max-width: 35px;width: 35px;">'.$rw['title'].'</td>
      <td style="max-width: 20px;width: 20px;">'.$rw['time'].'</td>
      <td style="max-width: 25px;width: 25px;"><a href="#" id="act-'.$rw['id'].'" onclick="delflag('.$rw['id'].', event)">Delete Flag</a></td>
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
  function load(x, e) {
    e.preventDefault();
    $.ajax ({
      type:'post',
      url:'fetch_posts.php',
      data:{
        pid: x
      },
      success:function(data) {
        if(data) {
            $( "#disp").html(data);
        }
      }
    });
  }
  function delflag(x, e) {
    e.preventDefault();
    if (confirm('Delete Flag?')==true) {
      e.preventDefault();
      $.ajax ({
        type:'post',
        url:'editpost.php',
        data:{
            flagdel: x
        },
        success:function(response) {
            if(response=="success") {
                alert("Flag Deleted!");
                $("#act-"+x).html("<a style='font-size:12px;color:red;'>[Deleted]</a>");
            }
        }
      });
    } else {
      e.preventDefault();
    }
}
</script>