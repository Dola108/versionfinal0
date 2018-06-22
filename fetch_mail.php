<style type="text/css">
.users {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

.users td{
    border: 1px solid #333;
    padding: 4px 4px;
    color: #eaeaea;
}
.users th {
    border: 1px solid #333;
    padding: 4px 4px;
    background-color: #eaeaea;
    color: black;
}
</style>
<table class="users">
  <tr>
    <th style="max-width: 15px;width: 15px;">Id</th>
    <th style="max-width: 40px;width: 40px;">Username</th>
    <th style="max-width: 50px;width: 50px;">E-mail</th>
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

$query = "SELECT * FROM `registration`";
$row=  mysqli_query($dbc, $query) or die($query."<br/><br/>".mysql_error());
$num_row = mysqli_num_rows($row);


$output = '';
$out = '';
while($num_row!=0) {
  $rw = mysqli_fetch_array($row, MYSQLI_BOTH);
  $n=$rw['id'];
  $mail = $rw['email'];
  $body = "Dear user ".$rw['username'].", we 1tag team would like to";
  $email = preg_replace( "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+/", "<a href=\"https://mail.google.com/mail/?view=cm&fs=1&to=".$mail."&su=1tag Team Message&body=".$body."\" target=\"_blank\">".$mail."</a>", $mail );
  $output .= '
  <table class="users">
    <tr>
      <td style="max-width: 15px;width: 15px;">'.$rw['id'].'</td>
      <td style="max-width: 40px;width: 40px;"><a href="#" onclick="load('.$rw['id'].', event)">'.$rw['username'].'</a></td>
      <td style="max-width: 50px;width: 50px;">'.$email.'</td>
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
      type:'get',
      url:'user_activity.php',
      data:{
        id: x
      },
      success:function(data) {
        if(data) {
            $( "#disp").html(data);
        }
      }
    });
  }
</script>