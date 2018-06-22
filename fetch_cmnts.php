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
    padding: 4px 4px;
    background-color: #eaeaea;
    color: black;
}
</style>
<a href="#">Comments</a><br>
<table class="users">
  <tr>
    <th style="width: 10px;max-width: 10px;">Id</th>
    <th style="width: 60px;max-width: 60px;">Content</th>
    <th style="width: 15px;max-width: 15px;">Parent</th>
    <th style="width: 20px;max-width: 20px;">Time</th>
    <th style="width: 20px;max-width: 20px;">Delete</th>
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

$query = "SELECT * FROM `comment` ORDER BY time DESC";
$row=  mysqli_query($dbc, $query) or die($query."<br/><br/>".mysql_error());
$num_row = mysqli_num_rows($row);


$output = '';
while($num_row!=0) {
  $rw = mysqli_fetch_array($row, MYSQLI_BOTH);
  $n=$rw['id'];
  $output .= '
  <table class="users" style="word-wrap: break-word;">
    <tr>
      <td style="max-width: 10px;width: 10px;">'.$rw['id'].'</td>
      <td style="max-width: 60px;width: 60px;">'.$rw['texts'].'</td>
      <td style="max-width: 15px;width: 15px;">'.$rw['c_id'].'</td>
      <td style="max-width: 20px;width: 20px;">'.$rw['time'].'</td>
      <td style="max-width: 20px;width: 20px;"><a href="#" id="act-'.$rw['id'].'" onclick="delcmnt('.$rw['id'].', event)">Delete</a></td>
    </tr>
  </table>
 ';
  $num_row--;
}

echo $output;

?>
<script>
  function delcmnt(x, e) {
    e.preventDefault();
    if (confirm('Delete Comment?')==true) {
        e.preventDefault();
        $.ajax ({
          type:'post',
          url:'editcomment.php',
          data:{
            delete: x
          },
          success:function(response) {
            if(response=="success") {
                alert("Comment Deleted!");
                $("#act-"+x).html("<a style='font-size:12px;color:red;'>[Deleted]</a>");
            }
          }
        });
    }
  }
</script>