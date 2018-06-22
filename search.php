<?php
	include('connection.php');
	
	if (!empty($_SESSION['uname'])) {
		$uname = $_SESSION['uname'];
		$_SESSION['uname'] = $uname;
	}
	if (isset($_POST['input'])) {
		if (strpos($_POST['input'], '@') !== false) {
			$un = $_POST['input'];
			$un = substr($un, 1);
			header('Location: profile.php?un='.$un);
		} else if (is_numeric($_POST['input'])) {
			$id = $_POST['input'];

			header('Location: fullpost.php?id='.$id);
		} else {
			$val = $_POST['input'];
			$val = "%23" . $val;
			header('Location: Tagboard.php?val='.$val);
		}
	}
?>