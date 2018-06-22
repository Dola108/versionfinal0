<?php
	session_start();
	include('connection.php');

	if(isset($_POST['edited'])) {
		$texts = $_POST['edited'];
		$id=$_POST['id'];
		mysqli_query($dbc, "UPDATE comment SET texts='$texts' WHERE id='".$id."'");
		echo "success";
		exit();
	}

	if(isset($_POST['delete'])) {
		$id=$_POST['delete'];
		$uname=$_SESSION['uname'];

		$q = "INSERT INTO `notifications` (receiver, title, c_id, sender, flag) VALUES ((SELECT username FROM `registration` WHERE username=(SELECT username FROM `comment` WHERE id='$id')), 'deleted', '$id', '$uname', 'admin')";
		mysqli_query($dbc, $q);

		function check_row($dbc, $lost_root) {
			$check = "SELECT * FROM comment WHERE c_id = '".$lost_root."'";
			$row=  mysqli_query($dbc, $check);
			$num_row = mysqli_num_rows($row);
			$rq = mysqli_fetch_array($row, MYSQLI_BOTH);
			$postid = $rq['c_id'];
		    while($num_row!=0) {
		    	$rw = mysqli_fetch_array($row, MYSQLI_BOTH);
		    	$del = "DELETE FROM comment WHERE id = '".$rw['id']."'";
		    	mysqli_query($dbc, "DELETE FROM likes WHERE c_id = '".$rw['id']."'");
		    	mysqli_query($dbc, $del);
		    	check_row($dbc, $rw['id']);
		    	$num_row--;
		    }
		}

		mysqli_query($dbc, "DELETE FROM comment WHERE id='".$id."'");
		mysqli_query($dbc, "DELETE FROM likes WHERE c_id='".$id."'");
		check_row($dbc, $id);

		echo "success";
		exit();
	}

	if(isset($_POST['liked'])) {
		$id=$_POST['liked'];
		$uname=$_SESSION['uname'];
		$i=1;
		$status="liked";
		mysqli_query($dbc, "INSERT INTO likes (username, count, c_id, checked) VALUES ('$uname', '$i', '$id', '$status')") or die();
		mysqli_query($dbc, "UPDATE comment SET likes=likes+1 WHERE id='".$id."'");
		$likes = mysqli_query($dbc, "SELECT likes FROM comment WHERE id='".$id."'");
		while($row = mysqli_fetch_array($likes)) {
		    $nums = $row['likes'];
		}
		echo $nums;
		exit();
	}

	if(isset($_POST['disliked'])) {
		$id=$_POST['disliked'];
		$uname=$_SESSION['uname'];
		$status="disliked";
		$i=-1;
		mysqli_query($dbc, "INSERT INTO likes (username, count, c_id, checked) VALUES ('$uname', '$i', '$id', '$status')") or die();
		mysqli_query($dbc, "UPDATE comment SET likes=likes-1 WHERE id='".$id."'");
		$likes = mysqli_query($dbc, "SELECT likes FROM comment WHERE id='".$id."'");
		while($row = mysqli_fetch_array($likes)) {
		    $nums = $row['likes'];
		}
		echo $nums;
		exit();
	}

	if(isset($_POST['unliked'])) {
		$id=$_POST['unliked'];
		$uname=$_SESSION['uname'];
		mysqli_query($dbc, "DELETE FROM likes WHERE c_id='".$id."' AND username='".$uname."'") or die();
		mysqli_query($dbc, "UPDATE comment SET likes=likes-1 WHERE id='".$id."'");
		$likes = mysqli_query($dbc, "SELECT likes FROM comment WHERE id='".$id."'");
		while($row = mysqli_fetch_array($likes)) {
		    $nums = $row['likes'];
		}
		echo $nums;
		exit();
	}

	if(isset($_POST['undliked'])) {
		$id=$_POST['undliked'];
		$uname=$_SESSION['uname'];
		mysqli_query($dbc, "DELETE FROM likes WHERE c_id='".$id."' AND username='".$uname."'") or die();
		mysqli_query($dbc, "UPDATE comment SET likes=likes+1 WHERE id='".$id."'");
		$likes = mysqli_query($dbc, "SELECT likes FROM comment WHERE id='".$id."'");
		while($row = mysqli_fetch_array($likes)) {
		    $nums = $row['likes'];
		}
		echo $nums;
		exit();
	}
?>