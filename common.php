<?php // common.php
	if (empty($_SESSION['uname'])) {
        header('Location: homepage.php');
      	// Immediately exit and send response to the client and do not go furthur in whatever script it is part of.
      	exit();
    }
?>