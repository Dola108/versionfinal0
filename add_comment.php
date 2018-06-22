<?php

//add_comment.php
session_start();
include('connection.php');

$error = '';
if(empty($_SESSION['uname']))
{
 $error .= '<p>Name is required</p>';
}
else {
	$uname = $_SESSION['uname'];
}
$comment_content = '';

if(empty($_POST["texts"]))
{
 $error .= '<p>Comment is required</p>';
}
else
{
 $comment_content = $_POST["texts"];
}
$pid = '';

if(empty($_POST["comment_id"]))
{
 $error .= '<p>Comment is required</p>';
}
else
{
 $pid = $_POST["comment_id"];
}

if(empty($_POST["posted_by"]))
{
 $error .= '<p>Comment is required</p>';
}
else
{
 $receiver = $_POST["posted_by"];
}

if(empty($_POST["post_id"]))
{
 $error .= '<p>Comment is required</p>';
}
else
{
 $postid = $_POST["post_id"];
}

if($error == '')
{
 $comment_content  = mysqli_real_escape_string($dbc, $comment_content);
 $query = "INSERT INTO comment (c_id, texts, username, receiver) VALUES ('$pid', '$comment_content', '$uname', '$receiver')";
 mysqli_query($dbc, $query);
 $q = "INSERT INTO `notifications` (receiver, title, c_id, sender) VALUES ('$receiver', 'comments', '$postid', '$uname')";
 mysqli_query($dbc, $q);
}
$result = array();
$result['code'] = 0;
$result['message'] = 'success';
echo json_encode($result);
?>
