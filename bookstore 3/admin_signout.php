<?php
// break the session and redirect to the index page or simply logout
	session_start();
	session_destroy();
	header("Location: index.php");
?>