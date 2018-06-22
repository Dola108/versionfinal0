<?php
header('Content-type: text/xml');

session_start();
include('connection.php');

$output = "<?xml version=\"1.0\" ?>\n";
$output .= "<users>\n";

$query = "SELECT * FROM `registration`";
$row=  mysqli_query($dbc, $query) or die($query."<br/><br/>".mysql_error());
$num_row = mysqli_num_rows($row);

while($num_row!=0) {
  $rw = mysqli_fetch_array($row, MYSQLI_BOTH);
  
  $output .= "\t<user>\n";
  $output .= "\t\t<username>@".$rw['username']."</username>\n";
  $output .= "\t\t<url>profile.php?un=".$rw['username']."</url>\n";
  $output .= "\t</user>\n";
  
  $num_row--;
}

$query = "SELECT * FROM `post`";
$row=  mysqli_query($dbc, $query) or die($query."<br/><br/>".mysql_error());
$num_row = mysqli_num_rows($row);

while($num_row!=0) {
  $rw = mysqli_fetch_array($row, MYSQLI_BOTH);
  $tag = str_replace('#', '', $rw['tag']);
  $output .= "\t<user>\n";
  $output .= "\t\t<username>".$tag."</username>\n";
  $output .= "\t\t<url>Tagboard.php?val=%23".$tag."</url>\n";
  $output .= "\t</user>\n";
  
  $num_row--;
}

$query = "SELECT * FROM `post`";
$row=  mysqli_query($dbc, $query) or die($query."<br/><br/>".mysql_error());
$num_row = mysqli_num_rows($row);
while($num_row!=0) {
  $rw = mysqli_fetch_array($row, MYSQLI_BOTH);
  $output .= "\t<user>\n";
  $output .= "\t\t<username>".$rw['id']."</username>\n";
  $output .= "\t\t<url>fullpost.php?id=".$rw['id']."</url>\n";
  $output .= "\t</user>\n";
  
  $num_row--;
}

$output .= "</users>";

echo $output;
?>